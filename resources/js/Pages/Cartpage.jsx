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
    const { outlet_code: outletCode, customer } = usePage().props;
    // const { post } = useForm();

    const [menus, setMenus] = useState([]);
    const [quantities, setQuantities] = useState({});
    const [subTotal, setSubTotal] = useState(0);
    const [totalPrice, setTotalPrice] = useState(0);
    const [selectedPaymentMethod, setSelectedPaymentMethod] = useState(null);

    // Menu List
    useEffect(() => {
        const storedMenus = JSON.parse(sessionStorage.getItem("selectedMenus")) || [];
        const storedQuantities = JSON.parse(sessionStorage.getItem("quantities")) || {};
        const paymentMethod = JSON.parse(sessionStorage.getItem('selectedPaymentMethod'));

        setMenus(storedMenus);
        setQuantities(storedQuantities);
        setSelectedPaymentMethod(paymentMethod);
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

    // Quantity
    useEffect(() => {
        sessionStorage.setItem("quantities", JSON.stringify(quantities));
    }, [quantities]);

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
    }

    const goToPayment = () => {
        sessionStorage.setItem("totalPrice", totalPrice);

        Inertia.visit(`/${outletCode}/payment-page`);
    };

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
                                onClick={ goToPayment }
                            />
                            <hr className="border border-gray-300" />
                            <CartSummary
                                menus={ menus }
                                subTotal={ subTotal }
                                totalPrice={ totalPrice }
                                quantities={ quantities }
                                onSubmit={ goToPayment }
                            />
                        </div>
                    </div>
                    <hr className="mt-4 border border-gray-300" />
                </section>
            </Main>
        </>
    )
}
