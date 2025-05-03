import { useEffect, useState } from 'react';
import { Wallet2, WalletCards, ArrowRightLeft, QrCode, ChevronDown, Banknote } from 'lucide-react';

const icons = {
    wallet: <WalletCards size={20} />,
    chevron: <ChevronDown size={20} />
};

export default function PaymentMethodSelector({ PaymentMethod, totalPrice, onSelect, onConfirm, selectedPaymentMethod }) {
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

    return (
        <>
            <div className="w-full max-w-md mx-auto">
                {/* E-Wallets */}
                <div className="py-3">
                    <button
                        onClick={() => setShowEwallets(!showEwallets)}
                        className="w-full flex items-center justify-between gap-4 cursor-pointer rounded border border-gray-100 bg-white p-3 shadow-sm transition-colors hover:bg-gray-50 has-checked:border-[#C60E2A] has-checked:ring-1 has-checked:ring-[#C60E2A]"
                    >
                        <div className="flex justify-center items-center gap-4 text-yellow-500">
                            <Wallet2 size={20} />
                            <span>E-Wallet</span>
                        </div>

                        <div className="flex justify-center items-center gap-2 text-gray-400">
                            <p className="text-md text-[#333]">{totalPrice || 0}</p>
                            <ChevronDown size={20} />
                        </div>
                    </button>

                    {
                        showEwallets && (
                            <div className="mb-4">
                                {
                                    PaymentMethod.filter((method) => method.type === 'E-Wallet').map((method) => {
                                        const isSelected = selectedMethod?.id === method.id;
                                        return (
                                            <div
                                                key={method.id}
                                                onClick={() => handleSelect(method)}
                                                className={`flex items-center justify-between gap-4 p-3 rounded border cursor-pointer transition-colors
                                                    ${isSelected ? 'border-[#C60E2A] ring-1 ring-[#C60E2A] bg-[#FFF0F1]' : 'border-gray-100 bg-white hover:bg-gray-100'}`}
                                            >
                                                <div className="flex justify-center items-center gap-4">
                                                    {icons[method.method.icon] || <WalletCards size={20} />}
                                                    <span>{method.method.name}</span>
                                                </div>

                                                <p className="text-md text-[#333]">{totalPrice || 0}</p>
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
                            <span>Bank Transfer</span>
                        </div>

                        <div className="flex justify-center items-center gap-2 text-gray-400">
                            <p className="text-md text-[#333]">{totalPrice || 0}</p>
                            <ChevronDown size={20} />
                        </div>
                    </button>

                    {
                        showBankTransfers && (
                            <div className="mb-4">
                                {
                                    PaymentMethod.filter((method) => method.type === 'Bank Transfer').map((method) => {
                                        const isSelected = selectedMethod?.id === method.id;
                                        return (
                                            <div
                                                key={method.id}
                                                onClick={() => handleSelect(method)}
                                                className={`flex items-center justify-between gap-4 p-3 rounded border cursor-pointer transition-colors
                                                    ${isSelected ? 'border-[#C60E2A] ring-1 ring-[#C60E2A] bg-[#FFF0F1]' : 'border-gray-100 bg-white hover:bg-gray-100'}`}
                                            >
                                                <div className="flex justify-center items-center gap-4">
                                                    {icons[method.method.icon] || <Banknote size={20} />}
                                                    <span>{method.method.name}</span>
                                                </div>

                                                <p className="text-md text-[#333]">{totalPrice || 0}</p>
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
                            PaymentMethod.filter((method) => method.type !== 'Bank Transfer' && method.type !== 'E-Wallet').map((method) => {
                                const isSelected = selectedMethod?.id === method.id;
                                return (
                                    <div
                                        key={method.id}
                                        onClick={() => handleSelect(method)}
                                        className={`flex items-center justify-between gap-4 p-3 rounded border cursor-pointer transition-colors
                                            ${isSelected ? 'border-[#C60E2A] ring-1 ring-[#C60E2A] bg-[#FFF0F1]' : 'border-gray-100 bg-white hover:bg-gray-100'}`}
                                    >
                                        <div className="flex justify-center items-center gap-4 text-blue-700">
                                            {icons[method.method.icon] || <QrCode size={20} />}
                                            <span>{method.method.name}</span>
                                        </div>

                                        <p className="text-md text-[#333]">{totalPrice || 0}</p>
                                    </div>
                                );
                            })
                        }
                    </button>
                </div>

                <button
                    onClick={() => onConfirm?.(selectedMethod)}
                    disabled={!selectedMethod}
                    className="w-full bg-[#C60E2A] text-white font-semibold py-2 rounded-lg disabled:bg-gray-400"
                >
                    Konfirmasi
                </button>
            </div>
        </>
    );
}
