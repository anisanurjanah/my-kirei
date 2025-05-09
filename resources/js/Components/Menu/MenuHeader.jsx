import { ReceiptText, ChevronDown, LogOut } from "lucide-react";

export default function MenuHeader({ isOpen, toggleOpen, showAlert }) {
    return (
        <>
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
                                onClick={ toggleOpen }
                            >
                                <ReceiptText />
                                <ChevronDown />
                            </button>
                            {
                                isOpen && (
                                    <div className="absolute right-0 top-full mt-2 w-32 bg-white border border-gray-200 rounded shadow-md cursor-pointer">
                                        <button
                                            onClick={ showAlert}
                                            className="block w-full px-4 py-2 text-left text-[#333] hover:bg-gray-100 cursor-pointer"
                                        >
                                            <span className="flex items-center"><LogOut className="me-2" size={16} />Keluar</span>
                                        </button>
                                    </div>
                                )
                            }
                        </div>
                    </div>
                </div>
            </header>
        </>
    )
}
