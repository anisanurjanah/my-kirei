import { Store } from 'lucide-react';

export default function Location() {
    return (
        <>
            <section id="location" className="h-auto flex flex-col justify-center items-center">
                <div className="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
                    <header className="text-center">
                        <h2 className="text-xl font-bold text-gray-900 sm:text-3xl">Lokasi Kami</h2>

                        <p className="mx-auto mt-4 max-w-md text-sm lg:text-lg text-gray-500">
                            Temukan kami dan rasakan pengalaman menyantap dimsum lezat dengan cita rasa khas yang tak terlupakan.
                        </p>
                    </header>

                    <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-2">
                        <div className="block rounded-md border border-gray-300 p-4 shadow-sm sm:p-6">
                            <div className="sm:flex sm:justify-between sm:gap-4 lg:gap-6">
                                <div className="sm:order-last sm:shrink-0">
                                    <Store
                                        className="size-12 text-[#DDD] sm:size-[64px] lg:ms-64 md:ms-36"
                                    />
                                </div>

                                <div className="mt-4 sm:mt-0">
                                    <h3 className="text-lg font-medium text-pretty text-gray-900">
                                        Nutiluan
                                    </h3>

                                    <p className="mt-1 text-sm text-gray-700">By John Doe</p>
                                </div>
                            </div>

                            <dl className="mt-6 flex gap-4 lg:gap-6">
                                <div className="flex items-center gap-2">
                                    <dt className="text-gray-700">
                                        <span className="sr-only"> Published on </span>

                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        strokeWidth="1.5"
                                        stroke="currentColor"
                                        className="size-5"
                                        >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"
                                        />
                                        </svg>
                                    </dt>

                                    <dd className="text-xs text-gray-700">31/06/2025</dd>
                                </div>
                            </dl>
                        </div>
                        <div className="block rounded-md border border-gray-300 p-4 shadow-sm sm:p-6">
                            <div className="sm:flex sm:justify-between sm:gap-4 lg:gap-6">
                                <div className="sm:order-last sm:shrink-0">
                                    <Store
                                        className="size-12 text-[#DDD] sm:size-[48px] lg:ms-64 md:ms-36"
                                    />
                                </div>

                                <div className="mt-4 sm:mt-0">
                                    <h3 className="text-lg font-medium text-pretty text-gray-900">
                                        Dreams
                                    </h3>

                                    <p className="mt-1 text-sm text-gray-700">By John Doe</p>
                                </div>
                            </div>

                            <dl className="mt-6 flex gap-4 lg:gap-6">
                                <div className="flex items-center gap-2">
                                    <dt className="text-gray-700">
                                        <span className="sr-only"> Published on </span>

                                        <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        strokeWidth="1.5"
                                        stroke="currentColor"
                                        className="size-5"
                                        >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"
                                        />
                                        </svg>
                                    </dt>

                                    <dd className="text-xs text-gray-700">31/06/2025</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </section>
        </>
    )
}
