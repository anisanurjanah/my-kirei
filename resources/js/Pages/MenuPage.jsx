import axios from 'axios';

import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage, useForm } from "@inertiajs/react";
import { ReceiptText, ChevronDown, LogOut, ShoppingCart, ChevronRight } from "lucide-react";

import Main from "@/Layouts/Main";

import LogoutAlert from "@/Components/AlertLogout";
import WelcomeAnnouncement from "@/Components/AnnouncementWelcome";

import WelcomeFlashMessage from "@/Helpers/WelcomeFlashMessage";

export default function MenuPage({ menus }) {
    const { outlet_code: outletCode, customer, flash } = usePage().props;
    const { post } = useForm();

    const [selectedMenus, setSelectedMenus] = useState([]);
    const [totalPrice, setTotalPrice] = useState(0);

    // Alert
    const {flashMsg, dismissFlash} = WelcomeFlashMessage(flash, customer)
    const [isOpen, setIsOpen] = useState(false);
    const [showAlert, setShowAlert] = useState(false);

    // Add menu
    const handleAddMenu = (menu) => {
        if (!menu || !menu.id) return;
        if (menu?.stock?.current_stock === 0) return;

        const menuAlreadyAdded = Array.isArray(selectedMenus) && selectedMenus.some((selected) => selected?.id === menu.id);
        if (menuAlreadyAdded) return;

        setSelectedMenus((prev) => [...prev, menu]);
        setTotalPrice((prev) => {
            const menuPrice = Number(menu.price) || 0;
            const promoDiscount = Number(menu.price_promo?.price_promo) || 0;
            const finalPrice = menuPrice - promoDiscount;

            return prev + Math.max(finalPrice, 0);
        });
    };

    const goToCart = () => {
        sessionStorage.setItem("selectedMenus", JSON.stringify(selectedMenus));

        Inertia.visit(`/${outletCode}/cart-page`, {
            state: { totalPrice }
        });
    };

    // Logout
    const handleSubmit = (e) => {
        e.preventDefault();
        post(`/${outletCode}/logout`);
        setShowAlert(false);
        localStorage.removeItem("customer");
    };

    // Customer
    useEffect(() => {
        if (customer) {
            localStorage.setItem("customer", JSON.stringify(customer));
        }
    }, [customer]);

    // Menu List
    useEffect(() => {
        const storedMenus = JSON.parse(sessionStorage.getItem("selectedMenus")) || [];
        if (storedMenus.length > 0) {
            setSelectedMenus(storedMenus);

            const total = storedMenus.reduce((acc, menu) => {
                const menuPrice = Number(menu.price) || 0;
                const menuDiscount = Number(menu.price_promo?.price_promo) || 0;

                return acc + Math.max(menuPrice - menuDiscount, 0);
            }, 0);

            setTotalPrice(total);
        }
    }, []);

    // Session Check
    useEffect(() => {
        const checkSession = async () => {
            try {
                const response = await axios.get('/check-session');
                if (!response.data.authenticated) {
                    localStorage.removeItem("customer");
                    Inertia.visit(`/${outletCode}/login`);
                }
            } catch (error) {
                console.error("Gagal cek sesi:", error);
            }
        };

        checkSession();
    }, []);

    return (
        <>
            {showAlert && (
                <div className="fixed h-screen inset-0 flex items-center justify-center bg-transparent backdrop-blur-md animate-fade-in z-50">
                    <LogoutAlert
                        title="Konfirmasi Logout"
                        message="Apakah Anda yakin ingin keluar?"
                        onClose={() => setShowAlert(false)}
                        onConfirm={handleSubmit}
                    />
                </div>
            )}

            <Head title={`Menu - ${outletCode.toUpperCase()}`} />

            { flashMsg && (
                <WelcomeAnnouncement
                    message={{ title: flashMsg }}
                    customer={customer.name}
                    onClose={dismissFlash}
                />
            )}

            <header className="bg-white shadow-md top-0 left-0 w-full z-50">
                <div className="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 items-center justify-between">
                        <div className="md:flex md:items-center md:gap-12">
                            <h1 className="text-2xl md:text-3xl font-bold mx-2 md:mx-4">
                                KIREI <span className="text-[#C60E2A]">SUM</span>
                            </h1>
                        </div>

                        <div className="relative flex items-center text-[#C60E2A]">
                            <button
                                className="bg-none mx-2 md:mx-4 rounded flex items-center space-x-4 cursor-pointer"
                                onClick={() => setIsOpen(!isOpen)}
                            >
                                <ReceiptText />
                                <ChevronDown />
                            </button>
                            {isOpen && (
                                <div className="absolute right-0 top-full mt-2 w-32 bg-white border border-gray-200 rounded shadow-md cursor-pointer">
                                    <button
                                        onClick={() => setShowAlert(true)}
                                        className="block w-full px-4 py-2 text-left text-[#333] hover:bg-gray-100 cursor-pointer"
                                    >
                                        <span className="flex items-center"><LogOut className="me-2" size={16} />Keluar</span>
                                    </button>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </header>

            <div className="flex justify-center bg-gray-200 w-full">
                <div className="flex space-x-4 py-4 overflow-x-auto">
                    <button className="bg-red-500 text-white text-sm md:text-lg px-4 py-2 rounded">For You</button>
                    <button className="bg-gray-300 px-4 py-2 text-[#333] text-sm md:text-xl rounded">New Menu</button>
                    <button className="bg-gray-300 px-4 py-2 text-[#333] text-sm md:text-xl rounded">Chizu Series</button>
                </div>
            </div>

            <Main>
                <section className="p-4">

                    <div className="bg-white w-full">
                        <span className="flex items-center py-1">
                            <span className="shrink-0 pe-4">
                                <h2 className="text-lg md:text-3xl text-[#333] font-semibold">Rekomendasi Menu Untuk Kamu</h2>
                            </span>

                            <span className="h-px flex-1 bg-gray-300"></span>
                        </span>

                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                            {menus.map((menu) => (
                                <div key={menu.id}
                                    className={`relative block border border-gray-100 transition animate-slide-up h-full
                                        ${menu.price_promo?.price_promo && menu.stock.current_stock != 0 ? "rounded-tr-3xl" : "" }`}>
                                    <div className="relative w-full">
                                        {menu.price_promo?.price_promo && menu.stock.current_stock != 0 && (
                                            <span
                                                className="absolute -top-px -right-px rounded-tr-3xl rounded-bl-3xl bg-yellow-500
                                                    p-2 md:px-6 md:py-4 text-xs md:text-md font-medium tracking-widest text-white uppercase"
                                            >
                                                Hemat {Math.round(((menu.price - menu.price_promo.price_promo) / menu.price) * 100)}%
                                            </span>
                                        )}

                                        <img
                                            src={menu.image?.includes('menu-images/') ? `/storage/${menu.image}` : menu.image}
                                            alt={menu.name}
                                            className={`w-full h-24 md:h-48 object-cover
                                                ${menu.stock.current_stock == 0 ? "blur-md brightness-70" : ""}
                                                ${menu.price_promo?.price_promo && menu.stock.current_stock != 0 ? "rounded-tr-3xl" : "" }`}
                                        />

                                        {menu.stock.current_stock == 0 && (
                                            <div className="absolute inset-0 flex items-center justify-center">
                                                <span className="text-white font-bold text-md md:text-2xl uppercase">Habis</span>
                                            </div>
                                        )}
                                    </div>

                                    <div className="p-4 flex flex-col flex-grow">
                                        <div className="min-h-[48px] md:min-h-[84px] flex items-start">
                                            <strong className="text-md md:text-2xl font-medium text-[#333]">{menu.name}</strong>
                                        </div>

                                        <p className="mt-4 text-pretty text-gray-400 text-sm md:text-lg">
                                            IDR {menu.price_promo?.price_promo && menu.stock.current_stock !== 0
                                                ? menu.price - menu.price_promo.price_promo
                                                : menu.price.toLocaleString()}
                                        </p>

                                        <div className="mt-auto">
                                            <button
                                                className={`mt-4 w-full block rounded-md border py-2 text-sm md:text-md font-medium tracking-widest text-white uppercase transition-colors hover:bg-[#333] hover:border-[#333] hover:text-[#ffffff] cursor-pointer
                                                    ${menu.stock.current_stock == 0 ? "border-[#333] bg-[#333] opacity-50 cursor-not-allowed pointer-events-none" : "border-[#C60E2A] bg-[#C60E2A]"}`}
                                                onClick={() => handleAddMenu(menu)}
                                            >
                                                Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            ))}

                        </div>

                        {selectedMenus.length > 0 && (
                            <div className="fixed bottom-0 bg-white p-4 shadow-md flex justify-center items-center">
                                <button
                                    className="fixed bottom-8 left-1/2 transform -translate-x-1/2 bg-[#C60E2A] text-sm md:text-lg font-medium text-white px-4 py-2 rounded-md shadow-lg flex justify-between items-center gap-2 z-50 hover:bg-[#333333] hover:text-[#ffffff] cursor-pointer"
                                    onClick={goToCart}
                                >
                                    <ShoppingCart size={20} />
                                    <p className="me-4 md:me-8 text-md font-normal">IDR {totalPrice.toLocaleString()}</p>
                                    Pesan Sekarang <ChevronRight size={16} />
                                </button>
                            </div>
                        )}
                    </div>

                    <hr className="mt-4 border border-gray-300" />

                </section>
            </Main>
        </>
    )
}
