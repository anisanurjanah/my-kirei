import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/react";

import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import Titles from "@/Components/Titles";
import PaymentDetails from "@/Components/Payment/PaymentDetails";
import PaymentProgressSteps from "@/Components/Payment/PaymentProgressSteps";
import PaymentCountdownTimer from "@/Components/Payment/PaymentCountdownTimer";

export default function PaymentPage() {
    const {
        outlet_code: outletCode,
        selectedPaymentMethod: paymentMethods,
        payment,
    } = usePage().props;

    const [selectedPaymentMethod, setSelectedPaymentMethod] = useState(paymentMethods);
    const [paymentDetails, setPaymentDetails] = useState(null);

    useEffect(() => {
        if (paymentMethods) {
            setSelectedPaymentMethod(paymentMethods);
            setPaymentDetails(paymentMethods)
        }
    }, [paymentMethods]);

    useEffect(() => {
        const interval = setInterval(() => {
            if (payment?.payment_status !== 'Lunas' && payment?.payment_status !== 'Gagal') {
                Inertia.reload({ only: ['payment'] });
            }
        }, 10000);

        return () => clearInterval(interval);
    }, []);

    useEffect(() => {
        if (payment?.payment_status === 'Lunas') {
            setTimeout(() => {
                window.location.href = `/${outletCode}/orders/${ payment.order.order_number.toLowerCase() }`;
            }, 3000);
        }
    }, [payment]);

    return (
        <>
            <Head title={`Pembayaran - ${outletCode.toUpperCase()}`} />
            <Header />
            <Main>
                <PaymentProgressSteps outletCode={outletCode} />
                <section className="p-4">
                    <div className="bg-white w-full">
                        <Titles title="Pembayaran" />
                        <PaymentCountdownTimer expiryTime={ payment?.expiry_time } />
                        <PaymentDetails
                            selectedPaymentMethod={ selectedPaymentMethod }
                            payment={ payment }
                            paymentDetails={ paymentDetails }
                        />
                    </div>
                </section>
            </Main>
        </>
    )
}
