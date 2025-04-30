import { useState } from 'react';
import { Wallet2, Banknote, QrCode, ChevronDown } from 'lucide-react';

const eWallets = [
    { id: "gopay", name: "GoPay", icon: <Wallet2 size={20} /> },
    { id: "ovo", name: "OVO", icon: <Wallet2 size={20} /> },
    { id: "shopeepay", name: "ShopeePay", icon: <Wallet2 size={20} /> },
];

export default function PaymentMethodSelector({ onSelect }) {
    const [showEwallets, setShowEwallets] = useState(false);
    const [selectedMethod, setSelectedMethod] = useState(null);

    const handleEwalletSelect = (method) => {
        setSelectedMethod(method);
        onSelect?.(method.id);
    };

    const handlePayment = () => {
        if (!selectedMethod) {
            alert('Pilih metode pembayaran!');
            return;
        }

        console.log('Metode Pembayaran:', selectedMethod);
    };

    const borderClass = selectedMethod
        ? 'border-[#C60E2A] ring-1 ring-[#C60E2A]'
        : 'border-gray-300';

    return (
        <>
            <div className="w-full max-w-md mx-auto">
                <div className="mb-4">
                    <button
                        onClick={() => setShowEwallets(!showEwallets)}
                        className="w-full flex items-center justify-between gap-4 rounded border border-gray-300 bg-white p-3 shadow-sm transition-colors hover:bg-gray-50 has-checked:border-[#C60E2A] has-checked:ring-1 has-checked:ring-[#C60E2A]"
                    >
                        <div className="flex justify-center items-center gap-4">
                            <Wallet2 size={20} />
                            <span>{selectedMethod ? selectedMethod.name : "E-Wallet"}</span>
                        </div>

                        <div className="flex justify-center items-center gap-2">
                            <p className="text-md text-[#333]">Free</p>
                            <ChevronDown size={20} />
                        </div>
                    </button>

                    {showEwallets && (
                        <div className="mb-4">
                            {eWallets.map((method) => {
                                const isSelected = selectedMethod?.id === method.id;
                                return (
                                    <div
                                        key={method.id}
                                        onClick={() => handleEwalletSelect(method)}
                                        className={`flex items-center justify-between gap-4 p-3 rounded border cursor-pointer transition-colors
                                            ${isSelected ? 'border-[#C60E2A] ring-1 ring-[#C60E2A] bg-[#FFF0F1]' : 'border-gray-300 bg-white hover:bg-gray-100'}`}
                                    >
                                        <div className="flex justify-center items-center gap-4">
                                            {method.icon}
                                            <span>{method.name}</span>
                                        </div>
                                        
                                        <p className="text-md text-[#333]">Free</p>
                                    </div>
                                );
                            })}
                        </div>
                    )}
                </div>

                <button
                    onClick={handlePayment}
                    disabled={!selectedMethod}
                    className="w-full bg-[#C60E2A] text-white font-semibold py-2 rounded-lg disabled:bg-gray-400"
                >
                    Konfirmasi
                </button>
            </div>
        </>
    );
}
