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
            if (payment?.payment_status !== 'Lunas') {
                Inertia.reload({ only: ['payment'] });
            }
        }, 10000);

        return () => clearInterval(interval);
    }, []);

    useEffect(() => {
        if (payment?.payment_status === 'Lunas') {
            setTimeout(() => {
                // Redirect to order detail page setelah pembayaran sukses
                window.location.href = `/${outletCode}/order-detail-page/${payment.order.order_number}`;
            }, 5000);
        } else if (payment?.payment_status === 'Gagal') {
            // Tampilkan pesan gagal atau error
            alert('Pembayaran Gagal, silakan coba lagi.');
        }
    }, [payment]); // Pastikan payment status ter-update


    // useEffect(() => {
    //     console.log('Payment status:', payment?.payment_status);

    //     // Jika pembayaran sudah Lunas, lakukan redirect
    //     if (payment?.payment_status === 'Lunas') {
    //         setTimeout(() => {
    //             Inertia.visit(`/${outletCode}/order-detail-page/${payment.order.order_number}`);
    //         }, 5000);
    //     }

    //     // Jika pembayaran Ditunda, kamu bisa menunggu atau memberikan informasi tambahan
    //     else if (payment?.payment_status === 'Ditunda') {
    //         console.log('Payment is delayed, waiting for status update...');
    //         // Bisa tambahkan logic untuk memeriksa status pembaruan setiap beberapa detik
    //     }
    // }, [payment, outletCode]);


    // useEffect(() => {
    //     console.log('payment status:', payment?.payment_status);

    //     if (payment?.payment_status === 'Lunas') {
    //         setTimeout(() => {
    //             console.log('Redirecting to:', `/${outletCode}/order-detail-page/${payment.order.order_number}`);
    //             Inertia.visit(`/${outletCode}/order-detail-page/${payment.order.order_number}`);
    //             // Inertia.visit(`/${outletCode}/order-detail-page/${payment.order.order_number}`);
    //             // Inertia.visit(`/${outletCode}/orders/${payment.order.order_number}`);
    //             // window.location.href = `/${outletCode}/order-detail-page/${payment.order.order_number}`;
    //         }, 5000);
    //     }
    // }, [payment]);

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
