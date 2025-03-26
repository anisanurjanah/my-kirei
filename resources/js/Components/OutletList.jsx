import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/react";
import { XCircle, Store } from "lucide-react";

export default function OutletList({ onClose }) {
    const { props } = usePage();
    const outlets = props.outlets;

    const handleLogin = (outlet_code) => {
        Inertia.visit(`/${outlet_code}/login`);
    };

    return (
        <>
            <div className={`fixed inset-0 flex items-center justify-center bg-transparent backdrop-blur-md animate-fade-in`}>
                <div className="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">
                    <div className="flex justify-between items-center mb-4">
                        <h2 className="text-xl font-semibold">
                            Daftar Outlet Kirei <span className="text-[#C60E2A]">Sum</span>
                        </h2>
                        <XCircle className="w-6 h-6 text-gray-500 cursor-pointer" onClick={onClose} />
                    </div>
                    <div className="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
                        {outlets?.length > 0 ? (
                            outlets.map((outlet) => (
                                <button
                                    key={outlet.id}
                                    onClick={() => handleLogin(outlet.outlet_code.toLowerCase() || '')}
                                    className="bg-transparent text-white cursor-pointer"
                                >
                                    <div className="h-32 rounded bg-white border border-[#C60E2A] flex flex-col items-center justify-center text-gray-800 font-semibold p-4">
                                        <Store className="w-10 h-10 text-[#C60E2A] mb-2" />
                                        <p>{outlet.name}</p>
                                    </div>
                                </button>
                            ))
                        ) : (
                            <p className="text-center col-span-3 text-gray-500">Tidak ada outlet tersedia.</p>
                        )}
                    </div>
                </div>
            </div>
        </>
    );
}
