import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/react";

import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import OrderProgressSteps from "@/Components/Order/OrderProgressSteps";
import OrderAccordionItem from "@/Components/Order/OrderAccordionItem";

export default function OrderDetailPage() {
    const {
        outlet_code: outletCode,
        order,
        payment,
        order_items,
    } = usePage().props;

    console.log(usePage().props);

    const [orderItems, setOrderItems] = useState(order_items);

    const orders = [
        { title: 'Outlet', subtitle: order.outlet.name },
        { title: 'Telepon', subtitle: order.customer.phone },
        { title: 'Nomor Pesanan', subtitle: order.order_number },
        { title: 'Nomor Bayar', subtitle: order.payment.payment_number },
        { title: 'Metode Bayar', subtitle: payment.payment_method.method.name },
        { title: 'Tipe Pesanan', subtitle: order.order_type  },
        { title: 'Waktu Pesanan', subtitle: new Date(order.order_date).toLocaleString('id-ID', {
            dateStyle: 'long',
            timeStyle: 'short'
        })}
    ];

    const goToMenu = () => {
        Inertia.visit(`/${outletCode}/menu-page`);
    };

    return (
        <>
            <Head title={`Ringkasan Pesanan - ${outletCode.toUpperCase()}`} />
            <Header />
            <Main>
                <OrderProgressSteps />
                <section className="p-4">
                    <div className="bg-white w-full">
                        <div className="flex justify-center">
                            <div className="w-full max-w-lg mt-4">
                                <div className="bg-gray-100 border border-gray-100 rounded-t-xl">
                                    <div className="flex items-center justify-center p-6 font-medium">
                                        <span className='text-[#333] text-lg md:text-xl'>{ order.order_number }</span>
                                    </div>
                                    <hr className="border border-gray-200" />
                                </div>
                                <OrderAccordionItem title="Ringkasan Pesanan" defaultOpen={ true }>
                                    <table className="w-full table-fixed">
                                        <tbody>
                                            {
                                                orders.map((order, index) => (
                                                    <tr key={ index } className="text-[#333] text-xs md:text-sm *:first:font-medium">
                                                        <td className="w-[35px] px-3 py-2 whitespace-nowrap">{ order.title }</td>
                                                        <td className="w-[65px] px-3 py-2 whitespace-nowrap">{ order.subtitle }</td>
                                                    </tr>
                                                ))
                                            }
                                        </tbody>
                                    </table>
                                </OrderAccordionItem>
                                <OrderAccordionItem title="Detail Pesanan">
                                    <table className="w-full table-auto">
                                        <thead className="text-left">
                                            <tr className="*:font-medium text-xs md:text-sm text-[#333]">
                                                <th className="px-3 py-2 whitespace-nowrap w-[50px]">*</th>
                                                <th className="px-3 py-2 whitespace-nowrap w-[200px]">Menu</th>
                                                <th className="px-3 py-2 text-right whitespace-nowrap w-[100px]">Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {
                                                orderItems.map((item, index) => (
                                                    <tr key={ index } className="text-[#333] text-xs md:text-sm *:first:font-medium">
                                                        <td className="px-3 py-2 whitespace-nowrap w-[50px]">{ item.quantity }</td>
                                                        <td className="px-3 py-2 whitespace-nowrap w-[200px]">{ item.menu.name }</td>
                                                        <td className="px-3 py-2 text-right whitespace-nowrap w-[100px]">
                                                            { item.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) }
                                                        </td>
                                                    </tr>
                                                ))
                                            }
                                            <tr className="text-[#333] text-xs md:text-sm *:first:font-medium border-t border-t-gray-200">
                                                <td className="px-3 py-2 whitespace-nowrap" colSpan={2}>Sub Total</td>
                                                <td className="px-3 py-2 text-right whitespace-nowrap w-[100px]">{ order.sub_total }</td>
                                            </tr>
                                            <tr className="text-[#333] text-xs md:text-sm *:first:font-medium">
                                                <td className="px-3 py-2 whitespace-nowrap" colSpan={2}>Diskon</td>
                                                <td className="px-3 py-2 text-right whitespace-nowrap w-[100px]">{ order.discount ?? 0 }</td>
                                            </tr>
                                            <tr className="text-[#333] text-xs md:text-sm *:first:font-medium">
                                                <td className="px-3 py-2 whitespace-nowrap" colSpan={2}>Total</td>
                                                <td className="px-3 py-2 text-right whitespace-nowrap w-[100px]">{ order.total_price }</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </OrderAccordionItem>
                                <div className="flex justify-end mt-4">
                                    <button
                                        onClick={ goToMenu }
                                        className="block rounded-sm bg-[#C60E2A] px-5 py-3 text-sm text-gray-100 transition hover:bg-[#333] cursor-pointer"
                                    >
                                        Kembali
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </Main>
        </>
    )
}
