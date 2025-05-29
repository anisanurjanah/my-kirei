import axios from 'axios';

import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage, useForm } from "@inertiajs/react";

import Main from "@/Layouts/Main";

import Titles from "@/Components/Titles";
import MenuHeader from "@/Components/Menu/MenuHeader";
import MenuNavigation from "@/Components/Menu/MenuNavigation";
import MenuList from "@/Components/Menu/MenuList";
import MenuDetail from "@/Components/Menu/MenuDetail";
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

        const updatedMenus = [...selectedMenus, menu];
        const updatedQuantities = { ...quantities };

        if (!updatedQuantities[menu.id]) {
            updatedQuantities[menu.id] = 1;
        }

        setSelectedMenus(updatedMenus);
        setQuantities(updatedQuantities);
        setShowQuantity(prev => ({ ...prev, [menu.id]: true }));

        sessionStorage.setItem("selectedMenus", JSON.stringify(updatedMenus));
        sessionStorage.setItem("quantities", JSON.stringify(updatedQuantities));
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
                            title="Konfirmasi Keluar"
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
                <MenuDetail
                    showModal={ showModal }
                    selectedMenus={ selectedMenus }
                    quantities={ quantities }
                    selectedMenuDetail={ selectedMenuDetail }
                    onIncrease={ () => handleIncrease(selectedMenuDetail.id) }
                    onDecrease={ () => handleDecrease(selectedMenuDetail.id) }
                    onsubmit={ () => handleAddMenu(selectedMenuDetail) }
                    onChange={ () => setShowModal(false) }
                />
            </Main>
        </>
    )
}
