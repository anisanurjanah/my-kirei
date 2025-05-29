import OrderAccordionItem from "@/Components/Order/OrderAccordionItem";

export default function OrderSummary({ order, payment, order_items, onClick }) {
    const orders = [
        { title: 'Outlet', subtitle: order.outlet.name },
        { title: 'Telepon', subtitle: order.customer.phone },
        // { title: 'Nomor Pesanan', subtitle: order.order_number },
        { title: 'Nomor Bayar', subtitle: order.payment.payment_number },
        { title: 'Metode Bayar', subtitle: payment.payment_method.method.name },
        { title: 'Tipe Pesanan', subtitle: order.order_type  },
        { title: 'Waktu Pesanan', subtitle: new Date(order.order_date).toLocaleString('id-ID', {
            dateStyle: 'long',
            timeStyle: 'short'
        })}
    ];

    return(
        <>
            <div className="flex justify-center">
                <div className="w-full max-w-lg mt-4">
                    <div className="bg-white border border-gray-100 rounded-t-xl p-6">
                        <p className='text-center text-[#888] text-xs md:text-sm'>Nomor Pesanan</p>
                        <div className="flex items-center justify-center font-medium mt-1">
                            <span className='text-[#333] text-lg underline md:text-2xl tracking-[2px]'>{ order.order_number }</span>
                        </div>
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
                                    order_items.map((item, index) => (
                                        <tr key={ index } className="text-[#333] text-xs md:text-sm *:first:font-medium">
                                            <td className="px-3 py-2 whitespace-nowrap w-[50px]">{ item.quantity }</td>
                                            <td className="px-3 py-2 whitespace-nowrap w-[200px]">{ item.menu.name }</td>
                                            <td className="px-3 py-2 text-right whitespace-nowrap w-[100px]">
                                                IDR { Number(item.price).toLocaleString() }
                                            </td>
                                        </tr>
                                    ))
                                }
                                <tr className="text-[#333] text-xs md:text-sm *:first:font-medium border-t border-t-gray-200">
                                    <td className="px-3 py-2 whitespace-nowrap" colSpan={2}>Sub Total</td>
                                    <td className="px-3 py-2 text-right whitespace-nowrap w-[100px]">IDR { Number(order.sub_total).toLocaleString() }</td>
                                </tr>
                                <tr className="text-[#333] text-xs md:text-sm *:first:font-medium">
                                    <td className="px-3 py-2 whitespace-nowrap" colSpan={2}>Diskon</td>
                                    <td className="px-3 py-2 text-right whitespace-nowrap w-[100px]">{ Number(order.discount).toLocaleString() ?? 0 }</td>
                                </tr>
                                <tr className="text-[#333] text-xs md:text-sm *:first:font-medium">
                                    <td className="px-3 py-2 whitespace-nowrap" colSpan={2}>Total</td>
                                    <td className="px-3 py-2 text-right whitespace-nowrap w-[100px]">IDR { Number(order.total_price).toLocaleString() }</td>
                                </tr>
                            </tbody>
                        </table>
                    </OrderAccordionItem>
                    <div className="flex justify-end mt-4">
                        <button
                            onClick={ onClick }
                            className="block rounded-sm bg-[#C60E2A] px-5 py-3 text-sm text-gray-100 transition hover:bg-[#333] cursor-pointer"
                        >
                            Kembali
                        </button>
                    </div>
                </div>
            </div>
        </>
    );
}
