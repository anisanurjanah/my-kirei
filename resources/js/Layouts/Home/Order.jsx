import { useState } from 'react';

import OutletList from "@/Components/OutletList";
import { UseOnScreen } from "@/Hooks/UseOnScreen";

export default function Order({ outlets  }) {
    const [ref, isVisible] = UseOnScreen({ threshold: 0.3 });
    const [isModalOpen, setIsModalOpen] = useState(false);

    return (
        <>
            <section
                ref={ ref }
                className={`h-auto transition-all duration-700 ${
                    isVisible ? "animate-slide-up opacity-100" : "opacity-0"
                }`}
            >
                <div className="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
                    <div className="bg-[#C60E2A] mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8 lg:py-16">
                        <div className="text-center">
                            <h2 className="text-xl font-extrabold text-white sm:text-2xl md:text-3xl">Nikmati Kelezatan Dimsum Sekarang!</h2>

                            <p className="mx-auto mt-4 max-w-lg text-sm md:text-md lg:text-lg text-white/70 md:mt-6 md:block md:text-md md:leading-relaxed">
                                Pesan dengan mudah dan rasakan sensasi dimsum autentik dari Kirei Sum, dibuat dengan bahan pilihan dan cita rasa istimewa.
                            </p>

                            <button
                                onClick={(e) => {
                                    e.preventDefault();
                                    setIsModalOpen(true);
                                }}
                                className="mt-4 md:mt-8 bg-white rounded-full border border-[#C60E2A] px-6 py-2 text-sm font-medium text-[#333] hover:bg-[#333] hover:text-white transition cursor-pointer"
                            >
                                Pesan disini
                            </button>

                            { isModalOpen &&
                                <OutletList
                                    outlets={ outlets }
                                    onClose={ () => setIsModalOpen(false) }
                                />
                            }
                        </div>
                    </div>
                </div>
            </section>
        </>
    )
}
