import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/react";
import { ChevronLeft } from "lucide-react";

import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import PaymentMethodSelector from '@/Components/Cart/PaymentMethodSelector';

export default function PaymentMethodPage() {
    const {
        outlet_code: outletCode,
        payment_method: paymentMethods,
        selectedPaymentMethod: InitialPaymentMethods,
    } = usePage().props;

    const [selectedPaymentMethod, setSelectedPaymentMethod] = useState(InitialPaymentMethods);
    const [totalPrice, setTotalPrice] = useState(0);

    useEffect(() => {
        const storedMenus = JSON.parse(sessionStorage.getItem("selectedMenus")) || [];
        const storedQuantities = JSON.parse(sessionStorage.getItem("quantities")) || {};

        const total = storedMenus.reduce((acc, menu) => {
            const menuQuantity = Number(storedQuantities[menu.id]) || 1;
            const menuPrice = Number(menu.price) - (Number(menu.price_promo?.price_promo) || 0 );

            return acc + Math.max(menuPrice, 0) * menuQuantity;
        }, 0);

        setTotalPrice(total);
    }, []);

    const handleSelect = (methodId) => {
        const selected = paymentMethods.find(method => method.id === methodId);
        setSelectedPaymentMethod(selected);
    };

    const handlePayment = () => {
        Inertia.post(`/${outletCode}/payment-method-store`, {
            payment_method_id: selectedPaymentMethod.id
        });
    };

    const goToCart = () => {
        Inertia.visit(`/${outletCode}/cart-page`);
    };

    return (
        <>
            <Head title={`Metode Pembayaran - ${outletCode.toUpperCase()}`} />
            <Header />
            <Main>
                <section className="after:mt-4 after:block after:h-1 after:w-full after:rounded-lg after:bg-gray-200 p-4">
                    <div className="bg-white w-full">
                        <span className="flex justify-center items-center py-2">
                            <button
                                onClick={ goToCart }
                                className="cursor-pointer"
                            >
                                <ChevronLeft className="text-gray-400 me-2" />
                            </button>
                            <span className="shrink-0 pe-4">
                                <h2 className="text-xl md:text-3xl text-[#333] font-semibold">Metode Pembayaran</h2>
                            </span>
                            <span className="h-px flex-1 bg-gray-300"></span>
                        </span>
                        <PaymentMethodSelector
                            paymentMethod={ paymentMethods }
                            totalPrice={ totalPrice.toLocaleString() }
                            onSelect={ handleSelect }
                            onConfirm={ handlePayment }
                            selectedPaymentMethod={ selectedPaymentMethod }
                        />
                    </div>
                </section>
            </Main>
        </>
    )
}
