import { X } from "lucide-react";

export default function MenuDetail({ showModal, selectedMenus, quantities, selectedMenuDetail, onIncrease, onDecrease, onsubmit, onChange }) {
    return(
        <>
            {
                showModal && selectedMenuDetail && (
                    <div
                        className="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4 animate-fade-in"
                        role="dialog"
                        aria-modal="true"
                    >
                        <div className="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                            <div className="flex items-start justify-between">
                                <h2 id="modalTitle" className="text-xl font-bold text-gray-900 sm:text-2xl"></h2>

                                <button
                                    onClick={ onChange }
                                    className="-me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none"
                                >
                                    <X />
                                </button>
                            </div>

                            {
                                selectedMenuDetail && (
                                    <div className="mt-4">
                                        <div className="group relative block overflow-hidden">
                                            <img
                                                src={ selectedMenuDetail.image?.includes('menu-images/')
                                                    ? `/storage/${ selectedMenuDetail.image }`
                                                    : `/${selectedMenuDetail.image}` }
                                                alt={ selectedMenuDetail.name }
                                                className="h-32 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72"
                                            />

                                            <div className="relative border border-gray-100 bg-white">
                                                <div className="text-left py-3">
                                                    <p className="text-gray-700 text-xs md:text-lg">
                                                        IDR{" "}
                                                        <span className="text-gray-400 line-through me-2">{ selectedMenuDetail.price }</span>
                                                        <span className="text-gray-700">
                                                            { selectedMenuDetail.price_promo?.price_promo ?
                                                                Number(selectedMenuDetail.price - selectedMenuDetail.price_promo.price_promo).toLocaleString() :
                                                                Number(selectedMenuDetail.price).toLocaleString()
                                                            }
                                                        </span>
                                                    </p>

                                                    <h3 className="mt-1.5 text-md md:text-2xl font-medium text-gray-900">{ selectedMenuDetail.name }</h3>

                                                    <p className="mt-1.5 line-clamp-3 text-gray-700 text-xs md:text-lg text-justify">
                                                        { selectedMenuDetail.description }
                                                    </p>
                                                </div>

                                                <div className="mt-4 space-y-2 text-end">
                                                    {
                                                        selectedMenus.some(menu => menu.id === selectedMenuDetail.id) && (
                                                                <div className="flex items-end justify-end gap-2 mb-3">
                                                                    <button
                                                                        type="button"
                                                                        onClick={ onDecrease }
                                                                        className="h-8 w-8 bg-[#C60E2A] text-white rounded-md cursor-pointer"
                                                                        disabled={ quantities[selectedMenuDetail.id] <= 1 }
                                                                    >
                                                                        −
                                                                    </button>

                                                                    <input
                                                                        type="number"
                                                                        min="1"
                                                                        value={ quantities[selectedMenuDetail.id] || 1 }
                                                                        readOnly
                                                                        className="h-8 w-12 rounded-md border-gray-200 bg-gray-50 p-0 text-center text-xs md:text-lg text-gray-600"
                                                                    />

                                                                    <button
                                                                        type="button"
                                                                        onClick={ onIncrease }
                                                                        className="h-8 w-8 bg-[#C60E2A] text-white rounded-md cursor-pointer"
                                                                    >
                                                                        +
                                                                    </button>
                                                                </div>
                                                        )
                                                    }

                                                    <button
                                                        onClick={ onsubmit }
                                                        className="block w-full rounded-sm bg-[#C60E2A] py-3 text-xs md:text-lg text-white cursor-pointer"
                                                    >
                                                        Tambah ke Keranjang
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                )
                            }
                        </div>
                    </div>
                )
            }
        </>
    )
}
