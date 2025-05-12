export default function MenuItem({ menu, onClickDetail, onClick }) {
    return (
        <>
            <div
                className={`relative block border border-gray-100 transition animate-slide-up h-full
                    ${ menu.price_promo?.price_promo && menu.stock.current_stock != 0 ? "rounded-tr-3xl" : "" }` }
            >
                <button
                    onClick={ () => onClickDetail(menu) }
                    className="relative p-0 w-full text-left"
                >
                    {
                        menu.price_promo?.price_promo && menu.stock.current_stock != 0 && (
                            <span
                                className="absolute -top-px -right-px rounded-tr-3xl rounded-bl-3xl bg-yellow-500
                                    p-2 md:px-6 md:py-4 text-xs md:text-md font-medium tracking-widest text-white uppercase"
                            >
                                Hemat { Math.round(((menu.price - menu.price_promo.price_promo) / menu.price) * 100) }%
                            </span>
                        )
                    }

                    <img
                        src={ menu.image?.includes('menu-images/')
                            ? `/storage/${ menu.image }`
                            : `/${menu.image}` }
                        alt={ menu.name }
                        className={ `w-full h-24 md:h-48 object-cover
                            ${ menu.stock.current_stock == 0 ? "blur-md brightness-70" : "" }
                            ${ menu.price_promo?.price_promo && menu.stock.current_stock != 0 ? "rounded-tr-3xl" : "" }` }
                    />

                    {
                        menu.stock.current_stock == 0 && (
                            <div className="absolute inset-0 flex items-center justify-center">
                                <span className="text-white font-bold text-md md:text-2xl uppercase">Habis</span>
                            </div>
                        )
                    }

                    <div className="p-2 flex flex-col flex-grow">
                        <div className="min-h-[64px] md:min-h-[96px] flex items-start">
                            <strong className="text-md md:text-2xl font-medium text-[#333]">{ menu.name }</strong>
                        </div>

                        <p className="mt-4 text-pretty text-gray-400 text-sm md:text-lg">
                            IDR { menu.price_promo?.price_promo && menu.stock.current_stock !== 0
                                ? Number(menu.price - menu.price_promo.price_promo).toLocaleString()
                                : Number(menu.price).toLocaleString() }
                        </p>
                    </div>
                </button>

                <div className="mt-auto px-2 pb-2">
                    <button
                        onClick={ () => onClick(menu) }
                        className={ `mt-4 w-full block rounded-md border py-2 text-sm md:text-md font-medium tracking-widest text-white uppercase transition-colors hover:bg-[#333] hover:border-[#333] hover:text-[#ffffff] cursor-pointer
                            ${ menu.stock.current_stock == 0 ? "border-[#333] bg-[#333] opacity-50 cursor-not-allowed pointer-events-none" : "border-[#C60E2A] bg-[#C60E2A]"}` }
                    >
                        Tambah
                    </button>
                </div>
            </div>
        </>
    )
}
