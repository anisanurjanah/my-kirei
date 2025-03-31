import { useState } from "react";

export default function LogoutAlert({ title, message, onClose, onConfirm }) {
    const [isVisible, setIsVisible] = useState(true);

    if (!isVisible) return null;

    return (
        <>
            <div role="alert" className="w-full max-w-sm md:max-w-sm m-8 md:mx-auto rounded-md border border-gray-300 bg-white p-4 shadow-sm">
                <div className="flex gap-4">
                    <div className="flex-1">
                        <strong className="font-medium text-gray-900">{title}</strong>
                        <p className="mt-0.5 text-sm text-gray-700">{message}</p>

                        <div className="mt-8 flex justify-end items-end gap-2">
                            <button
                                type="button"
                                className="rounded border border-gray-300 px-3 py-1.5 text-sm font-medium text-[#333] cursor-pointer"
                                onClick={() => {
                                    setIsVisible(false);
                                    if (onClose) onClose();
                                }}
                            >
                                Batal
                            </button>

                            <button
                                type="button"
                                className="rounded bg-[#C60E2A] border border-[#C60E2A] px-3 py-1.5 text-sm font-medium text-[#fff] shadow-sm hover:bg-[#333] hover:border-[#333] cursor-pointer"
                                onClick={onConfirm}
                            >
                                Keluar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
