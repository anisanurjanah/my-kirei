import { Trash2 } from "lucide-react";

export default function CartItem({ menu, quantities, onIncrease, onDecrease, onRemove }) {
    return (
        <>
            <li className="flex items-center gap-4 py-3 border-b border-gray-300">
                <img
                    src={ menu.image?.includes('menu-images/') ? `/storage/${ menu.image }` : `/${ menu.image }` }
                    alt={ menu.name }
                    className="hidden sm:block size-16 min-w-16 rounded-md object-cover"
                />

                <div className="flex flex-col gap-1">
                    <h3 className="text-sm text-[#333] font-bold">{ menu.name }</h3>

                    <dl className="mt-0.5 space-y-px text-[12px] text-[#333]">
                        <div>
                            <dd className="inline">
                            IDR{" "}
                            {
                                menu.price_promo?.price_promo
                                    ? (menu.price - menu.price_promo.price_promo).toLocaleString()
                                    : Number(menu.price).toLocaleString()
                            }
                            </dd>
                        </div>
                    </dl>
                </div>

                <div className="flex flex-1 items-center justify-end gap-2">
                    <div className="flex items-center gap-1">
                        <button
                            type="button"
                            onClick={ onDecrease }
                            className="h-8 w-8 bg-[#C60E2A] text-white rounded-md"
                            disabled={ quantities <= 1 }
                        >
                            −
                        </button>

                        <input
                            type="number"
                            min="1"
                            value={ quantities }
                            readOnly
                            className="h-8 w-12 rounded-md border-gray-200 bg-gray-50 p-0 text-center text-xs text-gray-600 [-moz-appearance:_textfield] focus:outline-hidden [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
                        />

                        <button
                            type="button"
                            onClick={ onIncrease }
                            className="h-8 w-8 bg-[#C60E2A] text-white rounded-md"
                        >
                            +
                        </button>

                        <button
                            className="text-gray-600 transition hover:text-red-600 p-2 md:p-4"
                            onClick={ onRemove }
                        >
                            <Trash2 size={16} />
                        </button>
                    </div>
                </div>
            </li>
        </>
    )
}
