import { useState } from "react";
import { Head, usePage, useForm } from "@inertiajs/react";
import { CircleCheck, UtensilsCrossed, ShoppingBasket, ReceiptText, Trash2, Ticket } from "lucide-react";

import Main from "@/Layouts/Main";

export default function CartPage({ menus }) {
    const { outlet_code: outletCode, customer } = usePage().props;
    // const { post } = useForm();

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

                    <ol className="grid grid-cols-3 text-sm font-medium text-gray-500">
                        <li className="relative flex justify-start text-blue-600">
                            <span className="absolute start-0 -bottom-[1.75rem] rounded-full bg-blue-600 text-white">
                                <CircleCheck />
                            </span>

                            <span className="hidden sm:block"> Menu </span>
                            <UtensilsCrossed className="sm:hidden" />
                        </li>

                        <li className="relative flex justify-center text-blue-600">
                            <span className="absolute -bottom-[1.75rem] left-1/2 -translate-x-1/2 rounded-full bg-blue-600 text-white">
                                <CircleCheck />
                            </span>

                            <span className="hidden sm:block"> Keranjang </span>
                            <ShoppingBasket className="sm:hidden" />
                        </li>

                        <li className="relative flex justify-end">
                            <span className="absolute end-0 -bottom-[1.75rem] rounded-full bg-gray-600 text-white">
                                <CircleCheck />
                            </span>

                            <span className="hidden sm:block"> Nota </span>
                            <ReceiptText className="sm:hidden" />
                        </li>
                    </ol>

                </section>

                <section className="p-4">

                    <div className="bg-white w-full">
                        <span className="flex items-center py-1">
                            <span className="shrink-0 pe-4">
                                <h2 className="text-lg md:text-3xl text-[#333] font-semibold">Detail Pesanan</h2>
                            </span>

                            <span className="h-px flex-1 bg-gray-300"></span>
                        </span>

                        <div className="mt-4">
                            <ul className="space-y-4">
                                <li className="flex items-center gap-4">
                                    <img
                                        src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=830&q=80"
                                        alt=""
                                        className="size-16 rounded-sm object-cover"
                                    />

                                    <div>
                                        <h3 className="text-sm text-gray-900">Basic Tee 6-Pack</h3>

                                        <dl className="mt-0.5 space-y-px text-[10px] text-gray-600">
                                            <div>
                                                <dt className="inline">Size:</dt>
                                                <dd className="inline">XXS</dd>
                                            </div>

                                            <div>
                                                <dt className="inline">Color:</dt>
                                                <dd className="inline">White</dd>
                                            </div>
                                        </dl>
                                    </div>

                                    <div className="flex flex-1 items-center justify-end gap-2">
                                        <form>
                                            <label htmlFor="Line1Qty" className="sr-only"> Quantity </label>

                                            <input
                                                type="number"
                                                min="1"
                                                value="1"
                                                id="Line1Qty"
                                                className="h-8 w-12 rounded-sm border-gray-200 bg-gray-50 p-0 text-center text-xs text-gray-600 [-moz-appearance:_textfield] focus:outline-hidden [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
                                            />
                                        </form>

                                        <button className="text-gray-600 transition hover:text-red-600">
                                            <span className="sr-only">Remove item</span>

                                            <Trash2 size={16} />
                                        </button>
                                    </div>
                                </li>
                            </ul>

                            <div className="mt-8 flex justify-end border-t border-gray-100 pt-8">
                                <div className="w-screen max-w-lg space-y-4">
                                    <dl className="space-y-0.5 text-sm text-gray-700">
                                        <div className="flex justify-between">
                                            <dt>Subtotal</dt>
                                            <dd>£250</dd>
                                        </div>

                                        <div className="flex justify-between">
                                            <dt>Discount</dt>
                                            <dd>-£20</dd>
                                        </div>

                                        <div className="flex justify-between !text-base font-medium">
                                            <dt>Total</dt>
                                            <dd>£200</dd>
                                        </div>
                                    </dl>

                                    <div className="flex justify-end">
                                        <span
                                            className="inline-flex items-center justify-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-indigo-700"
                                        >
                                            <Ticket className="me-1.5" size={16} />

                                            <p className="text-xs whitespace-nowrap">2 Discounts Applied</p>
                                        </span>
                                    </div>

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
