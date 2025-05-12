import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/react";
import { ChevronLeft } from "lucide-react";

import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import OrderHistory from "@/Components/Order/OrderHistory";

export default function OrderDetailPage() {
    const {
        outlet_code: outletCode,
        orders,
    } = usePage().props;

    const handleClick = (order) => {
        Inertia.visit(`/${outletCode}/orders/${order.order_number.toLowerCase()}`);
    };

    const goToMenu = () => {
        Inertia.visit(`/${outletCode}/menu-page`);
    };

    return (
        <>
            <Head title={`Riwayat Pesanan - ${outletCode.toUpperCase()}`} />
            <Header />
            <Main>
                <section className="p-4">
                    <div className="bg-white w-full">
                        <span className="flex justify-center items-center py-2">
                            <button
                                onClick={ goToMenu }
                                className="cursor-pointer"
                            >
                                <ChevronLeft className="text-gray-400 me-2" />
                            </button>
                            <span className="shrink-0 pe-4">
                                <h2 className="text-xl md:text-3xl text-[#333] font-semibold">Riwayat Pesanan</h2>
                            </span>
                            <span className="h-px flex-1 bg-gray-300"></span>
                        </span>
                        <OrderHistory
                            orders={ orders }
                            onClick={ handleClick }
                        />
                    </div>
                </section>
            </Main>
        </>
    )
}
