import { useState } from 'react';
import { UseOnScreen } from "@/Hooks/UseOnScreen";

export default function Menu({ menus = [] }) {
    const [showAll, setShowAll] = useState(false);
    const [ref, isVisible] = UseOnScreen({ threshold: 0.3 });
    
    const displayedMenus = showAll ? menus : (menus || []).slice(0, 4);

    return (
        <>
            <section
                id="menu"
                ref={ ref }
                className={`h-auto scroll-mt-24 flex flex-col justify-center items-center transition-all duration-700 ${
                    isVisible ? "animate-slide-up opacity-100" : "opacity-0"
                }`}
            >
                <div className="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
                    <header className="text-center">
                        <h2 className="text-xl font-bold text-gray-900 sm:text-3xl">Menu Kami</h2>

                        <p className="mx-auto mt-4 max-w-md text-sm lg:text-lg text-gray-500">
                            Nikmati beragam hidangan dimsum terbaik dengan cita rasa otentik yang memanjakan lidah
                        </p>
                    </header>

                    <ul className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        {
                            displayedMenus.map((menu) => (
                                <li key={ menu.id }
                                    className="group block overflow-hidden scale-90 transform transition duration-2000 animate-slide-up"
                                >
                                    <div className="group block overflow-hidden">
                                        <img
                                            src={ menu.image?.includes('menu-images/')
                                                ? `/storage/${ menu.image }`
                                                : `/${menu.image}` }
                                            alt={ menu.name }
                                            className="h-[250px] w-full object-cover transition duration-500 group-hover:scale-105"
                                        />

                                        <div className="relative bg-white pt-3">
                                            <h3 className="text-lg text-[#333] font-bold group-hover:underline group-hover:underline-offset-4">
                                                { menu.name }
                                            </h3>

                                            <p className="mt-2">
                                                <span className="tracking-wider text-[#333">
                                                    IDR { menu.price_promo?.price_promo && menu.stock.current_stock !== 0
                                                        ? Number(menu.price - menu.price_promo.price_promo).toLocaleString()
                                                        : Number(menu.price).toLocaleString() }
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            ))
                        }
                    </ul>

                    {
                        menus.length > 4 && (
                            <div className="text-center mt-6">
                                <button
                                    onClick={() => {
                                        if (showAll) {
                                            const element = document.getElementById('menu');
                                            if (element) {
                                                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                            }
                                        }

                                        setShowAll(!showAll);
                                    }}
                                    className="px-6 py-2 bg-[#C60E2A] text-white rounded hover:bg-[#333] transition cursor-pointer text-sm"
                                >
                                    { showAll ? 'Lihat lebih sedikit' : 'Lihat lebih banyak' }
                                </button>
                            </div>
                        )
                    }
                </div>
            </section>
        </>
    )
}
