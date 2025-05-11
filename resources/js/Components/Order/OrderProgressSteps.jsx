import { Inertia } from "@inertiajs/inertia";
import { CircleCheck, UtensilsCrossed, ShoppingBasket, CreditCard, ReceiptText } from "lucide-react";

export default function OrderProgressSteps() {
    const steps = [
        { label: "Menu", icon: "UtensilsCrossed", href: `` },
        { label: "Keranjang", icon: "ShoppingBasket", href: `` },
        { label: "Pembayaran", icon: "CreditCard", href: `` },
        { label: "Ringkasan", icon: "ReceiptText", href: `` }
    ];

    const icons = {
        UtensilsCrossed: UtensilsCrossed,
        ShoppingBasket: ShoppingBasket,
        CreditCard: CreditCard,
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
                                            className="relative flex flex-col items-center justify-center text-[#C60E2A]"
                                        >
                                            <button
                                                onClick={() => Inertia.visit( step.href )}
                                                className="flex flex-col items-center gap-1 cursor-pointer"
                                            >
                                                <span className="absolute -bottom-[1.75rem] rounded-full text-white bg-[#C60E2A]">
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
