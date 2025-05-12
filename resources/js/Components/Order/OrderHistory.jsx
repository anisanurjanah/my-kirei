export default function OrderHistory({ orders, onClick }) {
    return(
        <>
            {
                orders.map((order) => (
                    <button
                        key={ order.id }
                        onClick={() => onClick(order)}
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
        </>
    )
}
