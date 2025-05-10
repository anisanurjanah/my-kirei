import { CircleCheck, X } from "lucide-react";

export default function SuccessAlert({ message, onClose }) {
    return (
        <>
            <div role="alert" className="rounded-md border border-gray-300 bg-white p-4">
                <div className="flex items-start gap-4">
                    <CircleCheck size={24} className="text-green-600" />

                    <div className="flex-1">
                        <strong className="font-medium text-gray-900">{message?.title}</strong>
                        <p className="mt-0.5 text-sm text-gray-700">{message?.body}</p>
                    </div>

                    <button
                        className="-m-3 rounded-full p-1.5 text-gray-500 transition-colors hover:bg-gray-50 hover:text-gray-700"
                        type="button"
                        onClick={onClose}
                    >
                        <span className="sr-only">Tutup</span>

                        <X size={20} />
                    </button>
                </div>
            </div>
        </>
    )
}
