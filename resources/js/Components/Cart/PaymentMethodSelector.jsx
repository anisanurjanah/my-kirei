import { useEffect, useState } from 'react';
import { Wallet2, ArrowRightLeft, ChevronDown } from 'lucide-react';
import { TriangleAlert } from "lucide-react";

export default function PaymentMethodSelector({ paymentMethod, totalPrice, onSelect, onConfirm, selectedPaymentMethod }) {
    const [showEwallets, setShowEwallets] = useState(false);
    const [showBankTransfers, setBankTransfers] = useState(false);
    const [selectedMethod, setSelectedMethod] = useState(null);

    useEffect(() => {
        if (selectedPaymentMethod) {
            setSelectedMethod(selectedPaymentMethod);
            if (selectedPaymentMethod.type === 'E-Wallet') {
                setShowEwallets(true);
                setBankTransfers(false);
            } else if (selectedPaymentMethod.type === 'Bank Transfer') {
                setShowEwallets(false);
                setBankTransfers(true);
            }
        }
    }, [selectedPaymentMethod]);

    const handleSelect = (method) => {
        setSelectedMethod(method);
        onSelect?.(method.id);
    };

    const isMethodDisabled = (id) => {
        return [2, 6].includes(id);
    };

    return (
        <>
            <div className="w-full max-w-md mx-auto mt-4">
                {/* E-Wallets */}
                <div className="py-3">
                    <button
                        onClick={() => setShowEwallets(!showEwallets)}
                        className="w-full flex items-center justify-between gap-4 cursor-pointer rounded border border-gray-100 bg-white p-3 shadow-sm transition-colors hover:bg-gray-50 has-checked:border-[#C60E2A] has-checked:ring-1 has-checked:ring-[#C60E2A]"
                    >
                        <div className="flex justify-center items-center gap-4 text-yellow-500">
                            <Wallet2 size={20} />
                            <span className='text-sm md:text-md'>E-Wallet</span>
                        </div>

                        <div className="flex justify-center items-center gap-2 text-gray-400">
                            <p className="text-sm md:text-md text-[#333]">{totalPrice || 0}</p>
                            <ChevronDown size={20} />
                        </div>
                    </button>

                    {
                        showEwallets && (
                            <div className="mb-4">
                                {
                                    paymentMethod.filter((method) => method.type === 'E-Wallet').map((method) => {
                                        const isSelected = selectedMethod?.id === method.id;
                                        return (
                                            <div
                                                key={ method.id }
                                                onClick={() => {
                                                    if (!isMethodDisabled(method.id)) handleSelect(method);
                                                }}
                                                className={`flex items-center justify-between gap-4 p-3 rounded border transition-colors
                                                    ${ isSelected ? 'border-[#C60E2A] ring-1 ring-[#C60E2A] bg-[#FFF0F1]' : 'border-gray-100 bg-white hover:bg-gray-100' }
                                                    ${ isMethodDisabled(method.id) ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }
                                                `}
                                            >
                                                <div className="flex justify-center items-center gap-4">
                                                    <img
                                                        src={ `/${ method.method.image }` }
                                                        alt={ method.method.name }
                                                        className="sm:block size-6 min-w-6 object-contain"
                                                    />
                                                    <span className='text-sm md:text-md'>{ method.method.name }</span>
                                                </div>

                                                <div className="flex items-center gap-2">
                                                    {
                                                        !isMethodDisabled(method.id) && (
                                                            <p className="text-sm md:text-md text-[#333]">{ totalPrice || 0 }</p>
                                                        )
                                                    }

                                                    {
                                                        isMethodDisabled(method.id) && (
                                                            <span className="inline-flex items-center justify-center gap-2 rounded-full bg-red-100 px-2.5 py-0.5 text-red-700">
                                                                <TriangleAlert size={16} />
                                                                <p className="text-sm whitespace-nowrap">Dalam Perbaikan</p>
                                                            </span>
                                                        )
                                                    }
                                                </div>
                                            </div>
                                        );
                                    })
                                }
                            </div>
                        )
                    }
                </div>

                {/* Bank Transfer */}
                <div className="mb-3">
                    <button
                        onClick={() => setBankTransfers(!showBankTransfers)}
                        className="w-full flex items-center justify-between gap-4 cursor-pointer rounded border border-gray-100 bg-white p-3 shadow-sm transition-colors hover:bg-gray-50 has-checked:border-[#C60E2A] has-checked:ring-1 has-checked:ring-[#C60E2A]"
                    >
                        <div className="flex justify-center items-center gap-4 text-green-600">
                            <ArrowRightLeft size={20} />
                            <span className='text-sm md:text-md'>Bank Transfer</span>
                        </div>

                        <div className="flex justify-center items-center gap-2 text-gray-400">
                            <p className="text-sm md:text-md text-[#333]">{totalPrice || 0}</p>
                            <ChevronDown size={20} />
                        </div>
                    </button>

                    {
                        showBankTransfers && (
                            <div className="mb-4">
                                {
                                    paymentMethod.filter((method) => method.type === 'Bank Transfer').map((method) => {
                                        const isSelected = selectedMethod?.id === method.id;
                                        return (
                                            <div
                                                key={ method.id }
                                                onClick={() => {
                                                    if (!isMethodDisabled(method.id)) handleSelect(method);
                                                }}
                                                className={`flex items-center justify-between gap-4 p-3 rounded border transition-colors
                                                    ${ isSelected ? 'border-[#C60E2A] ring-1 ring-[#C60E2A] bg-[#FFF0F1]' : 'border-gray-100 bg-white hover:bg-gray-100' }
                                                    ${ isMethodDisabled(method.id) ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }
                                                `}
                                            >
                                                <div className="flex justify-center items-center gap-4">
                                                    <img
                                                        src={ `/${ method.method.image }` }
                                                        alt={ method.method.name }
                                                        className="sm:block size-6 min-w-6 object-contain"
                                                    />
                                                    <span className='text-sm md:text-md'>{ method.method.name }</span>
                                                </div>

                                                <div className="flex items-center gap-2">
                                                    {
                                                        !isMethodDisabled(method.id) && (
                                                            <p className="text-sm md:text-md text-[#333]">{ totalPrice || 0 }</p>
                                                        )
                                                    }

                                                    {
                                                        isMethodDisabled(method.id) && (
                                                            <span className="inline-flex items-center justify-center gap-2 rounded-full bg-red-100 px-2.5 py-0.5 text-red-700">
                                                                <TriangleAlert size={16} />
                                                                <p className="text-sm whitespace-nowrap">Dalam Perbaikan</p>
                                                            </span>
                                                        )
                                                    }
                                                </div>
                                            </div>
                                        );
                                    })
                                }
                            </div>
                        )
                    }
                </div>

                {/* QR Code */}
                <div className="mb-3">
                    <button className="w-full rounded border border-gray-100 bg-white shadow-sm transition-colors hover:bg-gray-50 has-checked:border-[#C60E2A] has-checked:ring-1 has-checked:ring-[#C60E2A]">
                        {
                            paymentMethod.filter((method) => method.type !== 'Bank Transfer' && method.type !== 'E-Wallet').map((method) => {
                                const isSelected = selectedMethod?.id === method.id;
                                return (
                                    <div
                                        key={method.id}
                                        onClick={() => handleSelect(method)}
                                        className={`flex items-center justify-between gap-4 p-3 rounded border cursor-pointer transition-colors
                                            ${isSelected ? 'border-[#C60E2A] ring-1 ring-[#C60E2A] bg-[#FFF0F1]' : 'border-gray-100 bg-white hover:bg-gray-100'}`}
                                    >
                                        <div className="flex justify-center items-center gap-4 text-blue-700">
                                            <img
                                                src={ `/${ method.method.image }` }
                                                alt={ method.method.name }
                                                className="sm:block size-6 min-w-6 object-contain"
                                            />
                                            <span className='text-sm md:text-md'>{method.method.name}</span>
                                        </div>

                                        <p className="text-sm md:text-md text-[#333]">{totalPrice || 0}</p>
                                    </div>
                                );
                            })
                        }
                    </button>
                </div>

                <button
                    onClick={() => onConfirm?.(selectedMethod)}
                    disabled={!selectedMethod}
                    className="w-full block rounded-sm bg-[#C60E2A] px-5 py-3 text-sm text-gray-100 transition hover:bg-[#333] cursor-pointer"
                >
                    Konfirmasi
                </button>
            </div>
        </>
    );
}
