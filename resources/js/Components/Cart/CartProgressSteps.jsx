import { CircleCheck, UtensilsCrossed, ShoppingBasket, BadgeDollarSign, ReceiptText } from "lucide-react";

export default function CartProgressSteps({ goToMenu }) {
    const steps = [
        { label: "Menu", icon: "UtensilsCrossed", action: goToMenu  },
        { label: "Keranjang", icon: "ShoppingBasket" },
        { label: "Pembayaran", icon: "BadgeDollarSign" },
        { label: "Ringkasan", icon: "ReceiptText" }
    ];

    const icons = {
        UtensilsCrossed: UtensilsCrossed,
        ShoppingBasket: ShoppingBasket,
        BadgeDollarSign: BadgeDollarSign,
        ReceiptText: ReceiptText,
    };

    return (
        <>
            <section className="relative p-4 flex justify-center">
                <div className="relative w-full">
                    <div className="after:content-[''] after:mt-4 after:block after:h-1 after:w-[100%] after:mx-auto after:rounded-lg after:bg-gray-200">
                        <ol className="grid grid-cols-4 text-sm font-medium text-[#333] text-center">
                            {
                                steps.map((step, index) => {
                                    const Icon = icons[step.icon];

                                    return (
                                        <li
                                            key={index}
                                            className={`relative flex flex-col items-center justify-center ${
                                                index != 2 && index != 3 ? "text-[#C60E2A]" : "text-[#333]"
                                            }`}
                                        >
                                            <button
                                                onClick={step.action}
                                                className="flex flex-col items-center gap-1 cursor-pointer"
                                            >
                                                <span className={`absolute -bottom-[1.75rem] rounded-full text-white ${
                                                    index != 2 && index != 3 ? "bg-[#C60E2A]" : "bg-[#333]"
                                                }`}>
                                                    <CircleCheck />
                                                </span>

                                                <span className="hidden sm:block">{ step.label }</span>
                                                <Icon className="w-5 h-5 sm:hidden" />
                                            </button>
                                        </li>
                                    )
                                })
                            }
                        </ol>
                    </div>
                </div>
            </section>
        </>
    )
}
