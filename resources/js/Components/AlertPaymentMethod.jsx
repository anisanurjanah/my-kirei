import { XCircle, X } from "lucide-react";

export default function AlertPaymentMethod({ showPaymentWarning, onClose }) {
    return(
        <>
            {
                showPaymentWarning && (
                    <div
                        className="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4 animate-fade-in"
                        role="dialog"
                        aria-modal="true"
                    >
                        <div className="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                            <div className="w-full max-w-md rounded-lg p-2">
                                <div className="flex justify-end">
                                    <button
                                        onClick={ onClose }
                                        className="-me-4 -mt-4 rounded-full text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none"
                                    >
                                        <X />
                                    </button>
                                </div>
                            </div>

                            <div className="flex justify-center py-6">
                                <XCircle size={84} className="text-red-600" />
                            </div>

                            <p className="text-pretty text-gray-700">
                                Silakan pilih metode pembayaran terlebih dahulu sebelum melanjutkan.
                            </p>
                        </div>
                    </div>
                )
            }
        </>
    )
}
