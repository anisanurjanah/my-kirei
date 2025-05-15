import { ChevronDown, Instagram, Mail, Phone } from 'lucide-react';
import { UseOnScreen } from "@/Hooks/UseOnScreen";

export default function Contact() {
    const [ref, isVisible] = UseOnScreen({ threshold: 0.3 });

    return (
        <>
            <section id="contact" className="h-auto scroll-mt-24 flex flex-col justify-center items-center">
                <div className="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
                    <header className="text-center">
                        <h2 className="text-xl font-bold text-gray-900 sm:text-3xl">Hubungi Kami</h2>

                        <p className="mx-auto mt-4 max-w-md text-sm lg:text-lg text-gray-500">
                            Kami senang mendengar dari Anda! Silakan hubungi kami melalui formulir atau kontak yang tersedia
                        </p>
                    </header>

                    <div className="mt-8 bg-white lg:grid lg:place-content-center">
                        <div className="mx-auto md:grid md:grid-cols-2 md:items-center md:gap-8">
                            <div
                                ref={ ref }
                                className={`inline-block w-full mb-3 md:mb-0 transition-all duration-700 ${
                                        isVisible ? "animate-slide-in-left opacity-100" : "opacity-0"
                                }`}
                            >
                                <div className="block rounded-md border border-gray-300 p-4 shadow-sm sm:p-6">
                                    <div className="flex justify-between sm:gap-4 lg:gap-6">
                                        <div>
                                            <h3 className="text-lg font-medium text-pretty text-gray-900">Email</h3>
                                            <p className="mt-1 text-sm text-gray-700">kireisum@gmail.com</p>
                                        </div>
                                        <Mail
                                            className="size-8 text-[#DDD] sm:size-[48px] lg:ms-48"
                                        />
                                    </div>
                                </div>
                                <div className="block rounded-md border border-gray-300 p-4 my-4 shadow-sm sm:p-6">
                                    <div className="flex justify-between sm:gap-4 lg:gap-6">
                                        <div>
                                            <h3 className="text-lg font-medium text-pretty text-gray-900">Telepon</h3>
                                            <p className="mt-1 text-sm text-gray-700">0895-3332-33231</p>
                                        </div>
                                        <Phone
                                            className="size-8 text-[#DDD] sm:size-[48px] lg:ms-48"
                                        />
                                    </div>
                                </div>
                                <div className="block rounded-md border border-gray-300 p-4 my-4 shadow-sm sm:p-6">
                                    <div className="flex justify-between sm:gap-4 lg:gap-6">
                                        <div>
                                            <h3 className="text-lg font-medium text-pretty text-gray-900">Instagram</h3>
                                            <p className="mt-1 text-sm text-gray-700">@kireisum</p>
                                        </div>
                                        <Instagram
                                            className="size-8 text-[#DDD] sm:size-[48px] lg:ms-48"
                                        />
                                    </div>
                                </div>
                            </div>

                            <form
                                action="#"
                                method="POST"
                                className={`max-w-lg transition-all duration-700 ${
                                    isVisible ? "animate-slide-in-right opacity-100" : "opacity-0"
                                }`}
                            >
                                <div className="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                                    <div className="sm:col-span-2">
                                        <label htmlFor="first-name" className="block text-sm/6 font-semibold text-gray-900">
                                            Nama
                                        </label>
                                        <div className="mt-2.5">
                                            <input
                                                id="first-name"
                                                name="first-name"
                                                type="text"
                                                autoComplete="given-name"
                                                className="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#C60E2A]"
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label htmlFor="email" className="block text-sm/6 font-semibold text-gray-900">
                                            Email
                                        </label>
                                        <div className="mt-2.5">
                                            <input
                                                id="email"
                                                name="email"
                                                type="email"
                                                className="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#C60E2A]"
                                            />
                                        </div>
                                    </div>
                                    <div className="">
                                        <label htmlFor="phone-number" className="block text-sm/6 font-semibold text-gray-900">
                                            Telepon
                                        </label>
                                        <div className="mt-2.5">
                                        <div className="flex rounded-md bg-white outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-[#C60E2A]">
                                            <div className="grid shrink-0 grid-cols-1 focus-within:relative">
                                                <label
                                                    id="country"
                                                    name="country"
                                                    autoComplete="country"
                                                    className="col-start-1 row-start-1 w-full appearance-none rounded-md py-2 pr-7 pl-3.5 text-base text-gray-500 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#C60E2A] sm:text-sm/6"
                                                >
                                                    +62
                                                </label>
                                                <ChevronDown
                                                    aria-hidden="true"
                                                    className="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                                />
                                            </div>
                                            <input
                                                id="phone-number"
                                                name="phone-number"
                                                type="text"
                                                placeholder="123-456-7890"
                                                className="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                            />
                                        </div>
                                        </div>
                                    </div>
                                    <div className="sm:col-span-2">
                                        <label htmlFor="message" className="block text-sm/6 font-semibold text-gray-900">
                                            Pesan
                                        </label>
                                        <div className="mt-2.5">
                                        <textarea
                                            id="message"
                                            name="message"
                                            rows={2}
                                            className="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-[#C60E2A]"
                                            defaultValue={''}
                                        />
                                        </div>
                                    </div>
                                </div>
                                <div className="mt-10">
                                    <button
                                        type="submit"
                                        className="block w-full rounded-md bg-[#C60E2A] px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs cursor-pointer hover:bg-[#333] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#C60E2A]"
                                    >
                                        Kirim
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </>
    )
}
