import { Link } from "@inertiajs/react";
import { useState } from "react";

import OutletList from "@/Components/OutletList";

export default function Header({ handleScroll }) {
    const [isModalOpen, setIsModalOpen] = useState(false);

    return (
        <>
            <header className="bg-white shadow-md fixed top-0 left-0 w-full z-50">
                <div className="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 items-center justify-between">
                        <div className="md:flex md:items-center md:gap-12">
                            <Link className="block text-black text-2xl font-bold" href="/">
                                KIREI <span className="text-[#C60E2A]">SUM</span>
                            </Link>
                        </div>

                        <div className="hidden md:block">
                            <nav aria-label="Global">
                                <ul className="flex items-center gap-16 text-sm">
                                    <li>
                                        <button onClick={() => handleScroll('about')} className="text-gray-500 transition hover:text-gray-500/75 cursor-pointer">Tentang</button>
                                    </li>

                                    <li>
                                        <button onClick={() => handleScroll('menu')} className="text-gray-500 transition hover:text-gray-500/75 cursor-pointer">Menu</button>
                                    </li>

                                    <li>
                                        <button onClick={() => handleScroll('location')} className="text-gray-500 transition hover:text-gray-500/75 cursor-pointer">Lokasi</button>
                                    </li>

                                    <li>
                                        <button onClick={() => handleScroll('contact')} className="text-gray-500 transition hover:text-gray-500/75 cursor-pointer">Kontak</button>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <div className="flex items-center gap-4">
                            <div className="sm:flex sm:gap-4">
                                <button
                                    className="rounded-md bg-[#C60E2A] px-5 py-2.5 text-sm font-medium text-white shadow-sm cursor-pointer"
                                    onClick={(e) => {
                                        e.preventDefault();
                                        setIsModalOpen(true);
                                    }}
                                >
                                    Masuk
                                </button>

                                {isModalOpen && <OutletList onClose={() => setIsModalOpen(false)} />}
                            </div>

                            <div className="block md:hidden">
                                <button
                                    className="rounded-sm p-2 text-[#C60E2A] transition hover:text-[#C60E2A]"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        className="size-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        strokeWidth="2"
                                    >
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </>
    );
}
