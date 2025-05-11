import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/react";
import { ChevronLeft } from "lucide-react";

import Main from "@/Layouts/Main";

import Header from "@/Components/Header";

export default function OrderDetailPage() {
    const {
        outlet_code: outletCode,
        orders,
    } = usePage().props;

    console.log(usePage().props)

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

                        {
                            orders.map((order) => (
                                <button
                                    key={order.id}
                                    onClick={() => handleClick(order)}
                                    className="w-full text-left cursor-pointer rounded-[10px] border border-gray-200 my-1"
                                >
                                    <article className="rounded-[10px] px-4 py-4">
                                        <time
                                            dateTime={ order.order_date }
                                            className="block text-xs text-gray-500"
                                        >
                                            { order.order_date }
                                        </time>

                                        <h3 className="mt-0.5 text-lg font-medium text-[#333]">
                                            { order.order_number }
                                        </h3>

                                        <p className="mt-0.5 text-xs md:text-sm text-[#333]">
                                            { order.order_items.map(item => item.menu.name).join(', ') }
                                        </p>

                                        <div className="mt-4 flex flex-wrap gap-1">
                                            <span
                                                className={`rounded-full px-2.5 py-0.5 text-xs whitespace-nowrap ${
                                                    order.order_type === 'Dine In'
                                                    ? 'bg-green-100 text-green-600'
                                                    : order.order_type === 'Take Away'
                                                    ? 'bg-yellow-100 text-yellow-600'
                                                    : 'bg-gray-100 text-gray-600'
                                                }`}
                                            >
                                                { order.order_type }
                                            </span>

                                            <span
                                                className={`rounded-full px-2.5 py-0.5 text-xs whitespace-nowrap ${
                                                    order.order_status === 'Selesai'
                                                    ? 'bg-green-100 text-green-600'
                                                    : order.order_status === 'Dibatalkan'
                                                    ? 'bg-red-100 text-red-600'
                                                    : order.order_status === 'Ditunda'
                                                    ? 'bg-yellow-100 text-yellow-600'
                                                    : 'bg-gray-100 text-gray-600'
                                                }`}
                                            >
                                                {order.order_status}
                                            </span>
                                        </div>
                                    </article>
                                </button>
                            ))
                        }
                    </div>
                </section>
            </Main>
        </>
    )
}
