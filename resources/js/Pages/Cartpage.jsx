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

    // const { post } = useForm();

    console.log(usePage().props);

    const [menus, setMenus] = useState([]);
    const [quantities, setQuantities] = useState({});
    const [subTotal, setSubTotal] = useState(0);
    const [totalPrice, setTotalPrice] = useState(0);
    const [selectedPaymentMethod, setSelectedPaymentMethod] = useState(paymentMethods);

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
        setMenus(updatedMenus);
        sessionStorage.setItem("selectedMenus", JSON.stringify(updatedMenus));

        const updatedQuantities = { ...quantities };
        delete updatedQuantities[id];
        setQuantities(updatedQuantities);
        sessionStorage.setItem("quantities", JSON.stringify(updatedQuantities));
    }

    const goToPaymentMethod = () => {
        Inertia.visit(`/${outletCode}/payment-method-page`);
    };

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

        const total = menus.reduce((acc, menu) => {
            const menuQuantity = Number(quantities[menu.id]) || 1;
            const menuPrice = Number(menu.price) - (Number(menu.price_promo?.price_promo) || 0 );

            return acc + Math.max(menuPrice, 0) * menuQuantity;
        }, 0);

        setSubTotal(subTotal);
        setTotalPrice(total);
    }, [menus, quantities]);

    useEffect(() => {
        setSelectedPaymentMethod(selectedPaymentMethod);
    }, [selectedPaymentMethod]);

    useEffect(() => {
        sessionStorage.setItem("quantities", JSON.stringify(quantities));
    }, [quantities]);

    return (
        <>
            <Head title={`Keranjang - ${outletCode.toUpperCase()}`} />
            <Header />
            <Main>
                <CartProgressSteps outletCode={ outletCode } />
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
                                totalPrice={ totalPrice }
                                quantities={ quantities }
                                onSubmit={ goToPaymentMethod }
                            />
                        </div>
                    </div>
                    <hr className="mt-4 border border-gray-300" />
                </section>
            </Main>
        </>
    )
}
