import { Head, Link, usePage, useForm } from "@inertiajs/react";
import { useState, useEffect } from "react";

import Jumbotron from "@/Layouts/Jumbotron";
import Footer from "@/Layouts/Footer";

import ErrorAlert from "@/Components/AlertError";
import SuccessAlert from "@/Components/AlertSuccess";

export default function Login() {
    const { props } = usePage();
    const outletCode = props.outlet_code;

    // Alert
    const flash = props.flash;
    const [flashMsg, setFlashMsg] = useState(flash);
    useEffect(() => {
        if (flash.success || flash.error) {
            setFlashMsg(flash);
        }
    }, [flash]);

    const handleAlertClose = () => {
        setFlashMsg(null);
    };

    // Handle data
    const { data, setData, post, errors } = useForm({
        phone: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        const formData = { phone: data.phone };
        post(`/${outletCode}/login`, formData);
    };

    // Phone input change
    const handlePhoneChange = (e) => {
        let formattedValue = e.target.value.replace(/\D/g, "");
        formattedValue = formattedValue.replace(/^62/, "");
        formattedValue = formattedValue.replace(/^0/, "");

        formattedValue = formattedValue.replace(/^(\d{3})(\d{4})?(\d{4})?/, (match, p1, p2, p3) => {
            return [p1, p2, p3].filter(Boolean).join("-");
        });

        setData({ ...data, phone: formattedValue });
    };

    return (
        <>
            <Head title={`Masuk - ${outletCode.toUpperCase()}`} />

            <header className="bg-white fixed top-0 left-0 w-full z-50">
                <div className="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 items-center justify-center">
                        <div className="md:flex md:items-center md:gap-12">
                            <Link className="block text-black text-2xl font-bold" href="/">
                                KIREI <span className="text-[#C60E2A]">SUM</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </header>

            <Jumbotron />

                <main className="max-w-screen-lg mx-auto">

                    <div className="flex justify-center py-4">
                        { flashMsg?.success && (
                            <SuccessAlert
                                message={{ title: flashMsg.success, body: "Pendaftaran akun Anda telah berhasil. Silakan masuk untuk melanjutkan." }}
                                onClose={handleAlertClose}
                            />
                        )}

                        {flashMsg?.error && (
                            <ErrorAlert
                                message={{ title: "Ups! Anda tidak dapat masuk", body: flashMsg.error }}
                            />
                        )}
                    </div>

                    <form onSubmit={handleSubmit}>
                        <div className="flex justify-center">
                            <div className="flex items-center w-84 bg-gray-100 border border-gray-300 rounded-md">
                                <span className="inline-flex items-center px-4 text-gray-500 bg-gray-100">
                                    (+62)
                                </span>
                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    className={`w-full px-4 py-3 bg-white border rounded-r-md text-gray-700 focus:text-gray-700 focus:ring-1 outline-none sm:text-sm
                                        ${errors.phone ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-gray-300 focus:ring-gray-300'}`}
                                    placeholder="Masukkan nomor telepon Anda"
                                    value={data.phone}
                                    onChange={handlePhoneChange}
                                    autoComplete="off"
                                    required
                                />
                            </div>
                        </div>

                        {errors.phone &&
                            <p className="text-red-500 text-center text-sm py-2">{errors.phone}</p>
                        }

                        <div className="pt-4">
                            <div className="flex justify-center pb-8 border-b border-b-gray-300">
                                <button type="submit" className="group flex items-center justify-center w-84 gap-2 rounded-lg border border-[#C60E2A] bg-[#C60E2A] px-4 py-2 cursor-pointer">
                                     <span className="font-medium text-white">
                                         Jelajahi
                                     </span>

                                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="white" className="size-6">
                                         <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                     </svg>
                                 </button>
                            </div>
                        </div>

                        <div className="flex justify-center pt-4">
                            <p className="text-sm text-gray-600">
                                Belum memiliki akun?{" "}
                                <a href={`/${outletCode}/register`} className="font-medium text-[#C60E2A] hover:text-[#C60E2A]">
                                    Daftar sekarang
                                </a>
                            </p>
                        </div>
                    </form>
                </main>

            <Footer />
        </>
    )
}
