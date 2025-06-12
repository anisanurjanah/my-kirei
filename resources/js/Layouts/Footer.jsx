export default function Header() {
    return (
        <>
            <footer className="bg-white">
                <div className="mx-auto max-w-screen-xl px-4 py-6 md:py-8 sm:px-6 lg:px-8">
                    <div className="sm:flex sm:items-center sm:justify-between">
                        <div className="flex justify-center text-[#C60E2A]">
                            <h3 className="block text-[#333] text-lg md:text-xl font-bold">
                                KIREI <span className="text-[#C60E2A]">SUM</span>
                            </h3>
                        </div>

                        <p className="flex justify-center mt-2 md:mt-4 text-center text-xs md:text-md text-gray-500 lg:mt-0 lg:text-right">
                            {/* Copyright &copy;<span className="font-bold mx-1"><a href="https://github.com/anisanurjanah">NEilR</a></span>2025. All rights reserved. */}
                            Copyright &copy;<span className="font-bold"><a href="https://github.com/anisanurjanah">Anisa Nurjanah</a></span>2025. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </>
    )
}
