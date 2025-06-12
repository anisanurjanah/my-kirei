import { Store } from 'lucide-react';
import { Phone } from 'lucide-react';
import { UseOnScreen } from "@/Hooks/UseOnScreen";

export default function Location({ outlets }) {
    const [ref, isVisible] = UseOnScreen({ threshold: 0.3 });

    return (
        <>
            <section
                id="location"
                ref={ ref }
                className={`h-auto scroll-mt-24 flex flex-col justify-center items-center transition-all duration-700 ${
                    isVisible ? "animate-slide-up opacity-100" : "opacity-0"
                }`}
            >
                <div className="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
                    <header className="text-center">
                        <h2 className="text-xl font-bold text-gray-900 sm:text-3xl">Lokasi Kami</h2>

                        <p className="mx-auto mt-4 max-w-md text-sm lg:text-lg text-gray-500">
                            Temukan kami dan rasakan pengalaman menyantap dimsum lezat dengan cita rasa khas yang tak terlupakan
                        </p>
                    </header>

                    <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-2">
                        {
                            outlets.map((outlet) => (
                                <div key={ outlet.id } className="block rounded-md border border-gray-300 p-4 shadow-sm sm:p-6">
                                    <div className="flex justify-between sm:gap-4 lg:gap-6">
                                        <div>
                                            <h3 className="text-lg font-medium text-pretty text-gray-900">
                                                { outlet.name }
                                            </h3>

                                            <p className="mt-1 text-sm text-gray-700">{ outlet.address }</p>
                                        </div>
                                        <Store
                                            className="size-12 text-[#DDD] sm:size-[64px] lg:ms-32"
                                        />
                                    </div>

                                    <dl className="mt-6 flex gap-4 lg:gap-6">
                                        <div className="flex items-center gap-2">
                                            <dt className="text-gray-700">
                                                <Phone size={12} />
                                            </dt>

                                            <dd className="text-xs text-gray-700">{ outlet.phone }</dd>
                                        </div>
                                    </dl>
                                </div>
                            ))
                        }
                    </div>
                </div>
            </section>
        </>
    )
}
