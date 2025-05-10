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

    console.log(usePage().props);

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
            Inertia.reload();
        }, 10000);

        return () => clearInterval(interval);
    }, []);

    useEffect(() => {
        console.log('payment status:', payment?.payment_status);

        if (payment?.payment_status === 'Lunas') {
            setTimeout(() => {
                Inertia.visit(`/${outletCode}/order-detail-page/${payment.order.order_number}`);
                // Inertia.visit(`/${outletCode}/orders/${payment.order.order_number}`);
                // window.location.href = `/${outletCode}/order-detail-page/${payment.order.order_number}`;
            }, 5000);
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
