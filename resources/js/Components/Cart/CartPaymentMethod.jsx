import { CircleDollarSign, ChevronRight } from "lucide-react";

export default function CartPaymentMethod({ selectedPaymentMethod, onClick }) {
    return (
        <>
            <div className="flex justify-between items-center py-4">
                <div className="flex justify-center items-center gap-2">
                    <CircleDollarSign size={16} className="text-[#C60E2A]" />
                    <span className="text-sm md:text-md font-bold text-[#333]">Metode Pembayaran</span>
                </div>

                <div className="flex justify-center items-center gap-2">
                    <button onClick={ onClick } className="text-xs md:text-sm text-[#333] cursor-pointer">
                    {
                        selectedPaymentMethod
                            ? selectedPaymentMethod.method.name.length > 16
                                ? selectedPaymentMethod.method.name.slice(0, 16) + '...'
                                : selectedPaymentMethod.method.name
                            : "Pilih Pembayaran"
                        }
                    </button>
                    <ChevronRight size={16} className="text-gray-400" />
                </div>
            </div>
        </>
    )
}
