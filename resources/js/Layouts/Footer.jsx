import { Link } from "@inertiajs/react";

export default function Header() {
    return (
        <>
            <footer className="bg-white">
                <div className="mx-auto max-w-screen-xl px-4 py-4 md:py-8 sm:px-6 lg:px-8">
                    <div className="sm:flex sm:items-center sm:justify-between">
                        <div className="flex justify-center text-[#C60E2A]">
                            <Link className="block text-[#333] text-lg md:text-2xl font-bold" href="/">
                                KIREI <span className="text-[#C60E2A]">SUM</span>
                            </Link>
                        </div>

                        <p className="flex justify-center mt-2 md:mt-4 text-center text-xs md:text-md text-gray-500 lg:mt-0 lg:text-right">
                            Copyright &copy;<span className="font-bold mx-1"><a href="https://github.com/anisanurjanah">NEilR</a></span>2025. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </>
    )
}
