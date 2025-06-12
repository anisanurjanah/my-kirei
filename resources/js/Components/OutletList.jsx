import { Inertia } from "@inertiajs/inertia";
import { X, Store } from "lucide-react";

export default function OutletList({ outlets, onClose }) {
    const handleLogin = (outlet_code) => {
        Inertia.visit(`/${outlet_code}/login`);
    };

    return (
        <>
            <div className={`fixed inset-0 flex items-center justify-center bg-transparent backdrop-blur-md animate-fade-in`}>
                <div className="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl mx-4">
                    <div className="flex justify-between items-center mb-4">
                        <h2 className="text-lg md:text-xl text-[#333] font-semibold">
                            Outlet <span className="text-[#C60E2A]">Kirei Sum</span>
                        </h2>
                        <X className="w-4 h-4 text-[#333] cursor-pointer" onClick={onClose} />
                    </div>
                    <div className="grid grid-cols-2 gap-4 lg:gap-8">
                        {
                            outlets?.length > 0 ? (
                                outlets.map((outlet) => (
                                    <button
                                        key={ outlet.id }
                                        onClick={ () => handleLogin(outlet.outlet_code.toLowerCase()) }
                                        className="bg-transparent text-white cursor-pointer"
                                    >
                                        <div className="h-24 md:h-32 rounded bg-white border border-[#C60E2A] flex flex-col items-center justify-center p-4">
                                            <Store className="w-8 h-8 md:w-10 md:h-10 text-[#C60E2A] mb-2" />
                                            <p className="text-sm md:text-lg text-[#333] font-semibold">{ outlet.name }</p>
                                        </div>
                                    </button>
                                ))
                            ) : (
                                <p className="text-center col-span-3 text-gray-500">Tidak ada outlet tersedia.</p>
                            )
                        }
                    </div>
                </div>
            </div>
        </>
    );
}
