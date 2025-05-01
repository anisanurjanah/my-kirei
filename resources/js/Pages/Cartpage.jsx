import { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage, useForm } from "@inertiajs/react";
import { CircleCheck, UtensilsCrossed, ShoppingBasket, ReceiptText, Trash2, Ticket, CircleDollarSign, ChevronRight } from "lucide-react";

import Main from "@/Layouts/Main";

export default function CartPage() {
    const { outlet_code: outletCode, customer } = usePage().props;
    // const { post } = useForm();

    const [menus, setMenus] = useState([]);
    const [quantities, setQuantities] = useState({});
    const [subTotal, setSubTotal] = useState(0);
    const [totalPrice, setTotalPrice] = useState(0);
    const [selectedPaymentMethod, setSelectedPaymentMethod] = useState(null);

    // Menu List
    useEffect(() => {
        const storedMenus = JSON.parse(sessionStorage.getItem("selectedMenus")) || [];
        const storedQuantities = JSON.parse(sessionStorage.getItem("quantities")) || {};
        const paymentMethod = JSON.parse(sessionStorage.getItem('selectedPaymentMethod'));

        setMenus(storedMenus);
        setQuantities(storedQuantities);
        setSelectedPaymentMethod(paymentMethod);
    }, []);

    useEffect(() => {
        if (menus.length === 0) return;

        const subTotal = menus.reduce((acc, menu) => {
            const menuQuantity = Number(quantities[menu.id]) || 1;
            const menuPrice = Number(menu.price);

            return acc + menuPrice * menuQuantity
        }, 0);

        const total = menus.reduce((acc, menu) => {
            const menuQuantity = Number(quantities[menu.id]) || 1;
            const menuPrice = Number(menu.price) - (Number(menu.price_promo?.price_promo) || 0 );

            return acc + Math.max(menuPrice, 0) * menuQuantity;
        }, 0);

        setSubTotal(subTotal);
        setTotalPrice(total);
    }, [menus, quantities]);

    // Quantity
    useEffect(() => {
        sessionStorage.setItem("quantities", JSON.stringify(quantities));
    }, [quantities]);

    // Update quantity
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

    // Remove menu
    const handleRemoveMenu = (id) => {
        const updatedMenus = menus.filter((menu) => menu.id !== id);
        setMenus(updatedMenus);
        sessionStorage.setItem("selectedMenus", JSON.stringify(updatedMenus));
    }

    const goToPayment = () => {
        sessionStorage.setItem("totalPrice", totalPrice);

        Inertia.visit(`/${outletCode}/payment-page`);
    };

    return (
        <>
            <Head title={`Keranjang - ${outletCode.toUpperCase()}`} />

            <header className="bg-white shadow-md top-0 left-0 w-full z-50">
                <div className="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 items-center justify-center">
                        <div className="md:flex md:items-center md:gap-12">
                            <h1 className="text-2xl md:text-3xl font-bold mx-2 md:mx-4">
                                KIREI <span className="text-[#C60E2A]">SUM</span>
                            </h1>
                        </div>
                    </div>
                </div>
            </header>

            <Main>
                <section className="after:mt-4 after:block after:h-1 after:w-full after:rounded-lg after:bg-gray-200 p-4">

                    <ol className="grid grid-cols-3 text-sm font-medium text-[#333]">
                        <li className="relative flex justify-start text-[#C60E2A]">
                            <button
                                onClick={() => Inertia.visit(`/${outletCode}/menu-page`)}
                                className="cursor-pointer"
                            >
                                <span className="absolute start-0 -bottom-[1.75rem] rounded-full bg-[#C60E2A] text-white">
                                    <CircleCheck />
                                </span>

                                <span className="hidden sm:block">Daftar Menu</span>
                                <UtensilsCrossed className="sm:hidden" />
                            </button>
                        </li>

                        <li className="relative flex justify-center text-[#C60E2A]">
                            <span className="absolute -bottom-[1.75rem] left-1/2 -translate-x-1/2 rounded-full bg-[#C60E2A] text-white">
                                <CircleCheck />
                            </span>

                            <span className="hidden sm:block">Keranjang Pesanan</span>
                            <ShoppingBasket className="sm:hidden" />
                        </li>

                        <li className="relative flex justify-end">
                            <span className="absolute end-0 -bottom-[1.75rem] rounded-full bg-gray-600 text-white">
                                <CircleCheck />
                            </span>

                            <span className="hidden sm:block">Ringkasan Pesanan</span>
                            <ReceiptText className="sm:hidden" />
                        </li>
                    </ol>

                </section>

                <section className="p-4">

                    <div className="bg-white w-full">
                        <span className="flex items-center py-1">
                            <span className="shrink-0 pe-4">
                                <h2 className="text-xl md:text-3xl text-[#333] font-semibold">Keranjang Pesanan</h2>
                            </span>

                            <span className="h-px flex-1 bg-gray-300"></span>
                        </span>

                        <div className="mt-4">
                            {menus.length === 0 ? (
                                <p className="text-[#333] text-center">Belum ada menu yang dipilih.</p>
                            ) : (
                                <ul className="space-y-4">
                                    {
                                        menus.map((menu, index) => {
                                            return (
                                                <li key={index} className="flex items-center gap-4 py-3 border-b border-gray-300">
                                                    <img
                                                        src={menu.image?.includes('menu-images/') ? `/storage/${menu.image}` : menu.image}
                                                        alt={menu.name}
                                                        className="hidden sm:block size-16 min-w-16 rounded-md object-cover"
                                                    />

                                                    <div className="flex flex-col gap-1">
                                                        <h3 className="text-sm text-[#333] font-bold">{menu.name}</h3>

                                                        <dl className="mt-0.5 space-y-px text-[12px] text-[#333]">
                                                            <div>
                                                                <dd className="inline">
                                                                IDR{" "}
                                                                {menu.price_promo?.price_promo
                                                                    ? (menu.price - menu.price_promo.price_promo).toLocaleString()
                                                                    : Number(menu.price).toLocaleString()}
                                                                </dd>
                                                            </div>
                                                        </dl>
                                                    </div>

                                                    <div className="flex flex-1 items-center justify-end gap-2">
                                                        <div className="flex items-center gap-1">
                                                            <form>
                                                                <button
                                                                    type="button"
                                                                    onClick={() => handleDecrease(menu.id)}
                                                                    className="h-8 w-8 bg-[#C60E2A] text-white rounded-md"
                                                                    disabled={(quantities[menu.id] || 1) <= 1}
                                                                >
                                                                    −
                                                                </button>

                                                                <input
                                                                    type="number"
                                                                    min="1"
                                                                    value={quantities[menu.id] || 1}
                                                                    readOnly
                                                                    className="h-8 w-12 rounded-md border-gray-200 bg-gray-50 p-0 text-center text-xs text-gray-600 [-moz-appearance:_textfield] focus:outline-hidden [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
                                                                />

                                                                <button
                                                                    type="button"
                                                                    onClick={() => handleIncrease(menu.id)}
                                                                    className="h-8 w-8 bg-[#C60E2A] text-white rounded-md"
                                                                >
                                                                    +
                                                                </button>
                                                            </form>

                                                            <button
                                                                className="text-gray-600 transition hover:text-red-600 p-2 md:p-4"
                                                                onClick={() => handleRemoveMenu(menu.id)}
                                                            >
                                                                <span className="sr-only">Hapus</span>
                                                                <Trash2 size={16} />
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            );
                                        }
                                    )}
                                </ul>
                            )}

                            <div className="flex justify-between items-center py-6">
                                <div className="flex justify-center items-center gap-2">
                                    <CircleDollarSign size={16} className="text-[#C60E2A]" />
                                    <span className="text-sm md:text-md text-[#333]">Metode Pembayaran</span>
                                </div>

                                <div className="flex justify-center items-center gap-2">
                                    <button onClick={goToPayment} className="text-sm md:text-md text-[#333] cursor-pointer">
                                        {selectedPaymentMethod ? selectedPaymentMethod.method.name : "Pilih Metode Pembayaran"}
                                    </button>
                                    <ChevronRight size={16} className="text-gray-400" />
                                </div>
                            </div>

                            <hr className="border border-gray-300" />

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
                                        <a
                                            href="#"
                                            className="block rounded-sm bg-[#C60E2A] px-5 py-3 text-sm text-gray-100 transition hover:bg-[#333]"
                                        >
                                            Checkout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr className="mt-4 border border-gray-300" />

                </section>
            </Main>
        </>
    )
}
