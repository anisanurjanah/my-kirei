import { Ticket } from "lucide-react";

export default function CartSummary({ menus, subTotal, totalPrice, quantities, onSubmit }) {
    return (
        <>
            <div className="mt-8 flex justify-end border-t border-gray-100 pt-8">
                <div className="w-screen max-w-lg space-y-4">
                    <dl className="space-y-0.5 text-sm text-[#333]">
                        <div className="flex justify-between">
                            <dt>Subtotal</dt>
                            <dd>IDR {subTotal.toLocaleString()}</dd>
                        </div>

                        <div className="flex justify-between">
                            <dt>Diskon</dt>
                            <dd>- IDR { menus.reduce((acc, menu) => {
                                const discount = Number(menu.price_promo?.price_promo) || 0;
                                const menuQuantity = Number(quantities[menu.id]) || 1;

                                return acc + discount * menuQuantity;
                            }, 0).toLocaleString()}</dd>
                        </div>

                        <div className="flex justify-between !text-base font-medium">
                            <dt>Total</dt>
                            <dd>IDR {totalPrice.toLocaleString()}</dd>
                        </div>
                    </dl>

                    {menus.some((menu) => Number(menu.price_promo?.price_promo) > 0) && (
                        <div className="flex justify-end">
                            <span className="inline-flex items-center justify-center rounded-full bg-green-200 px-2.5 py-0.5 text-green-700">
                                <Ticket className="me-1.5" size={16} />
                                <p className="text-xs whitespace-nowrap">Harga spesial berhasil kamu dapatkan!</p>
                            </span>
                        </div>
                    )}

                    <div className="flex justify-end">
                        <button
                            onClick={ onSubmit }
                            className="block rounded-sm bg-[#C60E2A] px-5 py-3 text-sm text-gray-100 transition hover:bg-[#333]"
                        >
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </>
    )
}
