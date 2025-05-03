import { useEffect, useState } from "react";
import { Head, Link, usePage, useForm } from "@inertiajs/react";
import { LogIn } from "lucide-react";

import Jumbotron from "@/Layouts/Jumbotron";
import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import ErrorAlert from "@/Components/AlertError";
import SuccessAlert from "@/Components/AlertSuccess";

export default function Login() {
    const { outlet_code: outletCode, flash } = usePage().props;

    // Alert
    const [flashMsg, setFlashMsg] = useState(flash);
    useEffect(() => {
        if (flash) {
            setFlashMsg(flash);
        }
    }, [flash]);

    const dismissFlash = () => {
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

            <Header />

            <Jumbotron />

            <Main>
                <section className="w-84 mx-auto flex flex-col items-center">
                    <div className="flex justify-center md:w-84 mx-8 py-4">
                        { flashMsg?.success && (
                            <SuccessAlert
                                message={{ title: flashMsg.success, body: "Pendaftaran akun Anda telah berhasil. Silakan masuk untuk melanjutkan." }}
                                onClose={dismissFlash}
                            />
                        )}

                        { flashMsg?.logout_success && (
                            <SuccessAlert
                                message={{ title: flashMsg.logout_success, body: "" }}
                                onClose={dismissFlash}
                            />
                        )}

                        { flashMsg?.error && (
                            <ErrorAlert
                                message={{ title: "Ups! Anda tidak dapat masuk", body: flashMsg.error }}
                            />
                        )}
                    </div>

                    <form onSubmit={handleSubmit}>

                        <div className="flex justify-center mb-6 mx-8">
                            <div className="flex items-center w-full md:w-84 bg-gray-100 border border-gray-300 rounded-md">
                                <span className="inline-flex items-center px-3 md:px-4 text-gray-500 bg-gray-100">
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

                        <div className="flex justify-center mx-8">
                            <button type="submit" className="group flex items-center justify-center w-full md:w-84 gap-2 rounded-lg border border-[#C60E2A] bg-[#C60E2A] px-4 py-2 cursor-pointer">
                                <span className="font-medium text-white">
                                    Jelajahi
                                </span>

                                <LogIn className="text-white" size={16} />
                            </button>
                        </div>

                    </form>
                </section>

                <hr className="mt-8 mb-4 border border-gray-300" />

                <div className="flex justify-center">
                    <p className="text-sm text-gray-600">
                        Belum memiliki akun?{" "}
                        <a href={`/${outletCode}/register`} className="font-medium text-[#C60E2A] hover:text-[#C60E2A]">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </Main>
        </>
    )
}
