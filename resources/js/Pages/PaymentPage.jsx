import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage, useForm } from "@inertiajs/react";

import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import Titles from "@/Components/Titles";

export default function PaymentPage() {
    const {
        outlet_code: outletCode,
        selectedPaymentMethod: paymentMethods,
        customer
    } = usePage().props;

    console.log(usePage().props);

    return (
        <>
            <Head title={`Pembayaran - ${outletCode.toUpperCase()}`} />
            <Header />
            <Main>
                <section className="p-4">
                    <div className="bg-white w-full">
                        <Titles title="Pembayaran" />
                    </div>
                </section>
            </Main>
        </>
    )
}
