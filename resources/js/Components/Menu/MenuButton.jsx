import { ShoppingCart, ChevronRight } from "lucide-react";

export default function MenuButton({ selectedMenus, totalPrice, onClick }) {
    return (
        <>
            {
                selectedMenus.length > 0 && (
                    <div className="fixed bottom-0 bg-white p-4 shadow-md flex justify-center items-center">
                        <button
                            className="fixed bottom-8 left-1/2 transform -translate-x-1/2 bg-[#C60E2A] text-sm md:text-lg font-medium text-white px-4 py-2 rounded-md shadow-lg flex justify-between items-center gap-2 z-50 hover:bg-[#333333] hover:text-[#ffffff] cursor-pointer"
                            onClick={ onClick }
                        >
                            <ShoppingCart size={20} />
                            <p className="me-4 md:me-8 text-md font-normal">IDR { Number(totalPrice).toLocaleString() }</p>
                            Pesan Sekarang <ChevronRight size={16} />
                        </button>
                    </div>
                )
            }
        </>
    )
}
