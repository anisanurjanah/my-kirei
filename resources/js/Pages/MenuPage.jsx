import axios from 'axios';

import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage, useForm } from "@inertiajs/react";
import { X } from "lucide-react";

import Main from "@/Layouts/Main";

import Titles from "@/Components/Titles";
import MenuHeader from "@/Components/Menu/MenuHeader";
import MenuNavigation from "@/Components/Menu/MenuNavigation";
import MenuList from "@/Components/Menu/MenuList";
import MenuButton from "@/Components/Menu/MenuButton";
import LogoutAlert from "@/Components/AlertLogout";
import WelcomeAnnouncement from "@/Components/AnnouncementWelcome";

import WelcomeFlashMessage from "@/Helpers/WelcomeFlashMessage";

export default function MenuPage() {
    const {
        outlet_code: outletCode,
        menus,
        customer,
        flash
    } = usePage().props;

    const { post } = useForm();

    const [selectedMenus, setSelectedMenus] = useState([]);
    const [selectedMenuDetail, setSelectedMenuDetail] = useState(null);
    const [quantities, setQuantities] = useState({});
    const [totalPrice, setTotalPrice] = useState(0);

    const {flashMsg, dismissFlash} = WelcomeFlashMessage(flash, customer)
    const [isOpen, setIsOpen] = useState(false);
    const [showAlert, setShowAlert] = useState(false);
    const [showModal, setShowModal] = useState(false);
    const [showQuantity, setShowQuantity] = useState({});

    // Session Check
    useEffect(() => {
        const checkSession = async () => {
            try {
                const response = await axios.get('/check-session');
                if (!response.data.authenticated) {
                    sessionStorage.removeItem("selectedMenus");
                    sessionStorage.removeItem("quantities");

                    Inertia.visit(`/${outletCode}/login`);
                }
            } catch (error) {
                console.error("Gagal cek sesi:", error);
            }
        };

        checkSession();
    }, []);

    // Menu List
    useEffect(() => {
        const storedMenus = JSON.parse(sessionStorage.getItem("selectedMenus")) || [];
        const storedQuantities = JSON.parse(sessionStorage.getItem("quantities")) || {};

        if (storedMenus.length > 0) {
            setSelectedMenus(storedMenus);
            setQuantities(storedQuantities);
        }
    }, []);

    useEffect(() => {
        if (selectedMenus.length === 0) return;

        const total = selectedMenus.reduce((acc, menu) => {
            const menuQuantity = Number(quantities[menu.id]) || 1;
            const menuPrice = Number(menu.price) - (Number(menu.price_promo?.price_promo) || 0 );

            return acc + Math.max(menuPrice, 0) * menuQuantity;
        }, 0);

        setTotalPrice(total);
    }, [selectedMenus, quantities]);

    // Add menu
    const handleAddMenu = (menu) => {
        if (!menu || !menu.id) return;
        if (menu?.stock?.current_stock === 0) return;

        const menuAlreadyAdded = Array.isArray(selectedMenus) && selectedMenus.some((selected) => selected?.id === menu.id);
        if (menuAlreadyAdded) return;

        const storedMenus = JSON.parse(sessionStorage.getItem("selectedMenus")) || [];
        const storedQuantities = JSON.parse(sessionStorage.getItem("quantities")) || {};

        const updatedQuantities = { ...storedQuantities };
        storedMenus.forEach(menu => {
            if (!updatedQuantities[menu.id]) {
                updatedQuantities[menu.id] = 1;
            }
        });

        if (!updatedQuantities[menu.id]) {
            updatedQuantities[menu.id] = 1;
        }

        sessionStorage.setItem("selectedMenus", JSON.stringify(storedMenus));
        sessionStorage.setItem("quantities", JSON.stringify(updatedQuantities));

        setSelectedMenus((prev) => [...prev, menu]);
        setQuantities(updatedQuantities);
        setShowQuantity(prev => ({ ...prev, [menu.id]: true }));
    }

    const handleMenuDetail = (menu) => {
        setSelectedMenuDetail(menu);
        setShowModal(true);
    };

    const handleIncrease = (id) => {
        setQuantities((prev) => ({
            ...prev,
            [id]: (prev[id] || 1) + 1,
        }));
    };

    const handleDecrease = (id) => {
        setQuantities((prev) => ({
            ...prev,
            [id]: prev[id] > 1 ? prev[id] - 1 : 1,
        }));
    };

    const goToCart = () => {
        sessionStorage.setItem("selectedMenus", JSON.stringify(selectedMenus));
        sessionStorage.setItem("quantities", JSON.stringify(quantities));

        Inertia.visit(`/${outletCode}/cart-page`);
    };

    const goToOrderHistory = () => {
        Inertia.visit(`/${outletCode}/orders/history`);
    };

    // Logout
    const handleSubmit = (e) => {
        e.preventDefault();
        post(`/${outletCode}/logout`);
        setShowAlert(false);
        sessionStorage.removeItem("selectedMenus");
        sessionStorage.removeItem("quantities");
    };

    return (
        <>
            {
                showAlert && (
                    <div className="fixed h-screen inset-0 flex items-center justify-center bg-transparent backdrop-blur-md animate-fade-in z-50">
                        <LogoutAlert
                            title="Konfirmasi Logout"
                            message="Apakah Anda yakin ingin keluar?"
                            onClose={ () => setShowAlert(false) }
                            onConfirm={ handleSubmit }
                        />
                    </div>
                )
            }
            <Head title={`Menu - ${outletCode.toUpperCase()}`} />
            {
                flashMsg && (
                    <WelcomeAnnouncement
                        message={ { title: flashMsg } }
                        customer={ customer.name }
                        onClose={ dismissFlash }
                    />
                )
            }
            <MenuHeader
                isOpen={ isOpen }
                toggleOpen={ () => setIsOpen(!isOpen) }
                onClick={ goToOrderHistory }
                showAlert={ () => setShowAlert(true) }
            />
            {/* <MenuNavigation /> */}
            <Main>
                <section className="p-4">
                    <div className="bg-white w-full">
                        <Titles title="Rekomendasi Menu Untuk Kamu" />
                        <MenuList
                            menus={ menus }
                            onClickDetail={ handleMenuDetail }
                            onClick={ handleAddMenu }
                        />
                        <MenuButton
                            selectedMenus={ selectedMenus }
                            totalPrice={ totalPrice }
                            onClick={ goToCart }
                        />
                    </div>
                    <hr className="mt-4 border border-gray-300" />
                </section>

                {
                    showModal && selectedMenuDetail && (
                        <div
                            className="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4"
                            role="dialog"
                            aria-modal="true"
                        >
                            <div className="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                                <div className="flex items-start justify-between">
                                    <h2 id="modalTitle" className="text-xl font-bold text-gray-900 sm:text-2xl"></h2>

                                    <button
                                        onClick={ () => setShowModal(false) }
                                        className="-me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none"
                                    >
                                        <X />
                                    </button>
                                </div>

                                {
                                    selectedMenuDetail && (
                                        <div className="mt-4">
                                            <button className="group relative block overflow-hidden">
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
                                                                            onClick={ () => handleDecrease(selectedMenuDetail.id) }
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
                                                                            onClick={() => handleIncrease(selectedMenuDetail.id)}
                                                                            className="h-8 w-8 bg-[#C60E2A] text-white rounded-md cursor-pointer"
                                                                        >
                                                                            +
                                                                        </button>
                                                                    </div>
                                                            )
                                                        }

                                                        <button
                                                            onClick={ () => handleAddMenu(selectedMenuDetail) }
                                                            className="block w-full rounded-sm bg-[#C60E2A] py-3 text-xs md:text-lg text-white cursor-pointer"
                                                        >
                                                            Tambah ke Keranjang
                                                        </button>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    )
                                }
                            </div>
                        </div>
                    )
                }
            </Main>
        </>
    )
}
