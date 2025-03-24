import { Head, Link, usePage } from "@inertiajs/react";
import Jumbotron from "@/Layouts/Jumbotron";
import Footer from "@/Layouts/Footer";

export default function Login() {
    const { component } = usePage()

    return (
        <>
            <Head title={component} />

            <header className="bg-white fixed top-0 left-0 w-full z-50">
                <div className="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 items-center justify-center">
                        <div className="md:flex md:items-center md:gap-12">
                            <Link className="block text-black text-2xl font-bold" href="/">
                                KIREI <span className="text-[#C60E2A]">SUM</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </header>

            <Jumbotron />

                <main className="max-w-screen-lg mx-auto">
                    <form>
                        <div className="flex justify-center">
                            <div className="flex items-center w-84 bg-gray-100 border border-gray-300 rounded-md">
                                <span className="inline-flex items-center px-4 text-gray-500 bg-gray-100">
                                    (+62)
                                </span>
                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    className="w-full px-4 py-3 bg-white border border-gray-300 rounded-r-md text-gray-700 focus:text-gray-700 focus:border-gray-300 focus:ring-1 focus:ring-gray-300 outline-none sm:text-sm"
                                    placeholder="Masukkan nomor telepon Anda"
                                    autoComplete="off"
                                    required
                                />
                            </div>
                        </div>

                        <div className="pt-4">
                            <div className="flex justify-center pb-8 border-b border-b-gray-300">
                                <a href="#" className="group flex items-center justify-center w-48 gap-2 rounded-lg border border-[#C60E2A] bg-[#C60E2A] px-4 py-2">
                                    <span className="font-medium text-white">
                                        Jelajahi
                                    </span>

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="white" className="size-6">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </form>
                </main>

            <Footer />
        </>
    )
}
