import { Head, usePage } from "@inertiajs/react";
import { ReceiptText } from "lucide-react";

import Footer from "@/Layouts/Footer";
import WelcomeAnnouncement from "@/Components/AnnouncementWelcome";
import WelcomeFlashMessage from "@/Helpers/WelcomeFlashMessage";

export default function Home({ menus }) {
    const { props } = usePage();

    const outletCode = props.outlet_code;
    const customer = props.customer;
    const flash = props.flash;

    const {flashMsg, dismissFlash} = WelcomeFlashMessage(flash, customer)

    return (
        <>
            <Head title={`Menu - ${outletCode.toUpperCase()}`} />

            <main className="max-w-screen">

                { flashMsg && (
                    <WelcomeAnnouncement
                        message={{ title: flashMsg }}
                        customer={customer.name}
                        onClose={dismissFlash}
                    />
                )}
                <div className="bg-white min-h-screen">
                    <nav className="bg-white text-[#C60E2A] p-4 flex justify-between shadow-md">
                        <h1 className="text-2xl font-bold mx-2 md:mx-4">
                            <span className="text-black">KIREI</span> SUM
                        </h1>
                        <button className="bg-none mx-2 md:mx-4 rounded flex items-center">
                            <ReceiptText />
                        </button>

                    </nav>

                    <section className="max-w-screen-lg mx-auto p-4">
                        <div className="flex space-x-4 py-4 overflow-x-auto">
                            <button className="bg-red-500 text-white px-4 py-2 rounded">For You</button>
                            <button className="bg-gray-300 px-4 py-2 rounded">New Menu</button>
                            <button className="bg-gray-300 px-4 py-2 rounded">Chizu Series</button>
                        </div>

                        <span className="flex items-center">
                            <span className="shrink-0 pe-4">
                                <h2 className="=md:text-3xl font-semibold">Rekomendasi Menu Untuk Kamu</h2>
                            </span>

                            <span className="h-px flex-1 bg-gray-300"></span>
                        </span>

                        <div className="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            {menus.map((menu) => (
                                <div key={menu.id}
                                    className={`relative block border border-gray-100 transition animate-slide-up h-full
                                        ${menu.price_promo?.price_promo && menu.stock.current_stock != 0 ? "rounded-tr-3xl" : "" }`}>
                                    <div className="relative w-full">
                                        {menu.price_promo?.price_promo && menu.stock.current_stock != 0 && (
                                            <span
                                                className="absolute -top-px -right-px rounded-tr-3xl rounded-bl-3xl bg-yellow-500
                                                    p-2 md:px-6 md:py-4 text-xs md:text-base font-medium tracking-widest text-white uppercase"
                                            >
                                                Hemat {Math.round(((menu.price - menu.price_promo.price_promo) / menu.price) * 100)}%
                                            </span>
                                        )}

                                        <img
                                            src={menu.image?.includes('menu-images/') ? `/storage/${menu.image}` : menu.image}
                                            alt={menu.name}
                                            className={`w-full h-24 md:h-64 object-cover
                                                ${menu.stock.current_stock == 0 ? "blur-md brightness-70" : ""}
                                                ${menu.price_promo?.price_promo && menu.stock.current_stock != 0 ? "rounded-tr-3xl" : "" }`}
                                        />

                                        {menu.stock.current_stock == 0 && (
                                            <div className="absolute inset-0 flex items-center justify-center">
                                                <span className="text-white font-bold text-lg">Habis</span>
                                            </div>
                                        )}
                                    </div>

                                    <div className="p-4 flex flex-col flex-grow">
                                        <div className="min-h-[48px] md:min-h-[84px] flex items-start">
                                            <strong className="text-md md:text-xl font-medium text-gray-900">{menu.name}</strong>
                                        </div>

                                        <p className="mt-4 text-pretty text-gray-700">IDR {menu.price.toLocaleString()}</p>

                                        <div className="mt-auto">
                                            <button
                                                className={`mt-4 w-full block rounded-md border px-5 py-2 md:py-3 text-sm font-medium tracking-widest text-white uppercase transition-colors hover:bg-[#333333] hover:text-[#ffffff] cursor-pointer
                                                    ${menu.stock.current_stock == 0 ? "border-[#333333] bg-[#333333] opacity-50 cursor-not-allowed pointer-events-none" : "border-[#C60E2A] bg-[#C60E2A]"}`}
                                            >
                                                Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </section>
                </div>
            </main>

            <Footer />
        </>
    )
}
