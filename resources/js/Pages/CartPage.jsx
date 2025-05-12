import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage, useForm } from "@inertiajs/react";

import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import Titles from "@/Components/Titles";
import CartList from "@/Components/Cart/CartList";
import CartPaymentMethod from "@/Components/Cart/CartPaymentMethod";
import CartProgressSteps from "@/Components/Cart/CartProgressSteps";
import CartSummary from "@/Components/Cart/CartSummary";

export default function CartPage() {
    const {
        outlet_code: outletCode,
        selectedPaymentMethod: paymentMethods,
        customer
    } = usePage().props;

    const [menus, setMenus] = useState([]);
    const [quantities, setQuantities] = useState({});
    const [subTotal, setSubTotal] = useState(0);
    const [discount, setDiscount] = useState(0);
    const [totalPrice, setTotalPrice] = useState(0);
    const [selectedPaymentMethod, setSelectedPaymentMethod] = useState(paymentMethods);

    const { setData, post } = useForm({
        outlet_code: outletCode,
        customer_id: customer.id,
        payment_method_id: selectedPaymentMethod ? selectedPaymentMethod.id : null,
        order_date: new Date().toISOString().slice(0, 10),
        items: menus.map((menu) => {
            return {
                menu_id: menu.id,
                quantity: quantities[menu.id] || 1,
                price: parseFloat(menu.price)
            };
        }),
        sub_total: parseInt(subTotal),
        discount: parseInt(discount),
        total_price: parseInt(totalPrice),
    });

    const handleSubmit = () => {
        if (!selectedPaymentMethod) {
            alert('Pilih metode pembayaran!');
            return;
        }

        post(`/${outletCode}/orders`, {
            onSuccess: () => {
                post('/clear-payment-session');

                sessionStorage.removeItem("selectedMenus");
                sessionStorage.removeItem("quantities");
            }
        });
    }

    // Menu List
    useEffect(() => {
        const storedMenus = JSON.parse(sessionStorage.getItem("selectedMenus")) || [];
        const storedQuantities = JSON.parse(sessionStorage.getItem("quantities")) || {};

        const updatedQuantities = { ...storedQuantities };
        storedMenus.forEach(menu => {
            if (!updatedQuantities[menu.id]) {
                updatedQuantities[menu.id] = 1;
            }
        });

        setMenus(storedMenus);
        setQuantities(updatedQuantities);
    }, []);

    useEffect(() => {
        if (menus.length === 0) return;

        const subTotal = menus.reduce((acc, menu) => {
            const menuQuantity = Number(quantities[menu.id]) || 1;
            const menuPrice = Number(menu.price);

            return acc + menuPrice * menuQuantity
        }, 0);

        const discount = menus.reduce((acc, menu) => {
            const menuDiscount = Number(menu.price_promo?.price_promo) || 0;
            const menuQuantity = Number(quantities[menu.id]) || 1;

            return acc + menuDiscount * menuQuantity;
        }, 0);

        const total = menus.reduce((acc, menu) => {
            const menuQuantity = Number(quantities[menu.id]) || 1;
            const menuPrice = Number(menu.price) - (Number(menu.price_promo?.price_promo) || 0 );

            return acc + Math.max(menuPrice, 0) * menuQuantity;
        }, 0);

        setSubTotal(subTotal);
        setDiscount(discount);
        setTotalPrice(total);
    }, [menus, quantities]);

    useEffect(() => {
        const items = menus.map((menu) => ({
            menu_id: menu.id,
            quantity: quantities[menu.id] || 1,
            price: parseInt(menu.price)
        }));

        setData((prev) => ({
            ...prev,
            items,
            sub_total: parseInt(subTotal),
            discount: parseInt(discount),
            total_price: parseInt(totalPrice)
        }));
    }, [menus, quantities, subTotal, discount, totalPrice]);

    useEffect(() => {
        sessionStorage.setItem("selectedMenus", JSON.stringify(menus));
        sessionStorage.setItem("quantities", JSON.stringify(quantities));
    }, [menus, quantities]);

    useEffect(() => {
        if (paymentMethods) {
            setSelectedPaymentMethod(paymentMethods);
        }
    }, [paymentMethods]);

    // Update quantity
    const handleIncrease = (id) => {
        setQuantities((prev) => ({
            ...prev,
            [id]: (prev[id] || 1) + 1,
        }));
    };

    const handleDecrease = (id) => {
        setQuantities((prev) => ({
            ...prev,
            [id]: prev[id] > 1 ? prev[id] - 1 : 1,
        }));
    };

    // Remove menu
    const handleRemoveMenu = (id) => {
        const updatedMenus = menus.filter((menu) => menu.id !== id);
        const updatedQuantities = { ...quantities };

        delete updatedQuantities[id];

        setMenus(updatedMenus);
        setQuantities(updatedQuantities);

        sessionStorage.setItem("selectedMenus", JSON.stringify(updatedMenus));
        sessionStorage.setItem("quantities", JSON.stringify(updatedQuantities));
    }

    const goToMenu = () => {
        Inertia.visit(`/${outletCode}/menu-page`);
    };

    const goToPaymentMethod = () => {
        Inertia.visit(`/${outletCode}/payment-method-page`);
    };

    return (
        <>
            <Head title={`Keranjang - ${outletCode.toUpperCase()}`} />
            <Header />
            <Main>
                <CartProgressSteps goToMenu={ goToMenu } />
                <section className="p-4">
                    <div className="bg-white w-full">
                        <Titles title="Keranjang Pesanan" />
                        <div className="mt-4">
                            <CartList
                                menus={ menus }
                                quantities={ quantities }
                                onIncrease={ handleIncrease }
                                onDecrease={ handleDecrease }
                                onRemove={ handleRemoveMenu }
                            />
                            <CartPaymentMethod
                                selectedPaymentMethod={ selectedPaymentMethod }
                                onClick={ goToPaymentMethod }
                            />
                            <hr className="border border-gray-300" />
                            <CartSummary
                                menus={ menus }
                                subTotal={ subTotal }
                                discount={ discount }
                                totalPrice={ totalPrice }
                                onSubmit={ handleSubmit }
                            />
                        </div>
                    </div>
                    <hr className="mt-4 border border-gray-300" />
                </section>
            </Main>
        </>
    )
}
