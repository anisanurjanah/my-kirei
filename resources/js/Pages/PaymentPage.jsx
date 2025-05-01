import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/react";
import { ChevronLeft } from "lucide-react";

import Main from "@/Layouts/Main";
import PaymentMethodSelector from '@/Components/PaymentMethodSelector';

export default function paymentPage() {
    const { outlet_code: outletCode, payment_method: paymentMethods } = usePage().props;

    const [selectedPaymentMethod, setSelectedPaymentMethod] = useState(null);
    const [totalPrice, setTotalPrice] = useState(0);

    useEffect(() => {
        const price = parseInt(sessionStorage.getItem("totalPrice")) || 0;
        const paymentMethod = JSON.parse(sessionStorage.getItem('selectedPaymentMethod'));

        setTotalPrice(price);
        setSelectedPaymentMethod(paymentMethod);
    }, []);

    const handleSelect = (methodId) => {
        const selected = paymentMethods.find(method => method.id === methodId);
        setSelectedPaymentMethod(selected);
    };

    const handlePayment = () => {
        if (!selectedPaymentMethod) {
            alert('Pilih metode pembayaran!');
            return;
        }

        sessionStorage.setItem('selectedPaymentMethod', JSON.stringify(selectedPaymentMethod));
        Inertia.visit(`/${outletCode}/cart-page`);
    };

    return (
        <>
            <Head title={`Metode Pembayaran - ${outletCode.toUpperCase()}`} />

            <header className="bg-white shadow-md top-0 left-0 w-full z-50">
                <div className="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 items-center justify-center">
                        <div className="md:flex md:items-center md:gap-12">
                            <h1 className="text-2xl md:text-3xl font-bold mx-2 md:mx-4">
                                KIREI <span className="text-[#C60E2A]">SUM</span>
                            </h1>
                        </div>
                    </div>
                </div>
            </header>

            <Main>
                <section className="after:mt-4 after:block after:h-1 after:w-full after:rounded-lg after:bg-gray-200 p-4">

                <div className="bg-white w-full">
                    <span className="flex justify-center items-center py-1">
                        <button
                            onClick={() => Inertia.visit(`/${outletCode}/cart-page`)}
                            className="cursor-pointer"
                        >
                            <ChevronLeft className="text-gray-400 me-2" />
                        </button>

                        <span className="shrink-0 pe-4">
                            <h2 className="text-xl md:text-3xl text-[#333] font-semibold">Metode Pembayaran</h2>
                        </span>

                        <span className="h-px flex-1 bg-gray-300"></span>
                    </span>

                    <div className="mt-4">
                        <PaymentMethodSelector
                            PaymentMethod={paymentMethods}
                            totalPrice={totalPrice.toLocaleString()}
                            onSelect={handleSelect}
                            onConfirm={handlePayment}
                            selectedPaymentMethod={selectedPaymentMethod}
                        />
                    </div>
                </div>

                </section>
            </Main>
        </>
    );
}
