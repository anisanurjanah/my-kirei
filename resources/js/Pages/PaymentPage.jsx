import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/react";
import { ChevronLeft } from "lucide-react";

import Main from "@/Layouts/Main";
import PaymentMethodSelector from '@/Components/PaymentMethodSelector';

export default function paymentPage() {
    const { outlet_code: outletCode } = usePage().props;

    const [selectedMethod, setSelectedMethod] = useState(null);

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
                        <PaymentMethodSelector onSelect={setSelectedMethod} />
                    </div>
                </div>

                </section>
            </Main>
        </>
    );
}
