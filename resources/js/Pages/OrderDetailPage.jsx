import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/react";

import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import OrderProgressSteps from "@/Components/Order/OrderProgressSteps";
import OrderSummary from "@/Components/Order/OrderSummary";

export default function OrderDetailPage() {
    const {
        outlet_code: outletCode,
        order,
        payment,
        order_items,
    } = usePage().props;

    const goToMenu = () => {
        Inertia.visit(`/${outletCode}/menu-page`);
    };

    return (
        <>
            <Head title={`Ringkasan Pesanan - ${outletCode.toUpperCase()}`} />
            <Header />
            <Main>
                <OrderProgressSteps goToMenu={ goToMenu } />
                <section className="p-4">
                    <div className="bg-white w-full">
                        <OrderSummary
                            order={ order }
                            payment={ payment }
                            order_items={ order_items }
                            onClick={ goToMenu }
                        />
                    </div>
                </section>
            </Main>
        </>
    )
}
