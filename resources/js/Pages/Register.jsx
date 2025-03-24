import { Head, Link } from "@inertiajs/react";
import { useState, useContext } from "react";

import { AuthContext } from "@/Context/AuthContext";

import Jumbotron from "@/Layouts/Jumbotron";
import Footer from "@/Layouts/Footer";
import ErrorAlert from "@/Components/AlertError";

export default function Register() {
    const { register, alert, errors  } = useContext(AuthContext);

    const [data, setData] = useState({
        name: "",
        phone: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        const formData = { name: data.name, phone: data.phone };
        register(formData);
    };

    return (
        <>
            <Head title="Register" />

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
                        {alert?.type === "error" && (
                            <ErrorAlert
                                message={{ title: "Pendaftaran gagal", body: alert.message }}
                            />
                        )}
                    </div>

                    <form onSubmit={handleSubmit}>
                        <div className="flex justify-center mb-4">
                            <div className="flex items-center w-84 bg-gray-100 border border-gray-300 rounded-md">
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    className="w-full px-4 py-3 bg-white border border-gray-300 rounded-md text-gray-700 focus:text-gray-700 focus:border-gray-300 focus:ring-1 focus:ring-gray-300 outline-none sm:text-sm"
                                    placeholder="Masukkan nama lengkap Anda"
                                    value={data.name}
                                    onChange={(e) => setData({ ...data, name: e.target.value })}
                                    autoComplete="off"
                                    required
                                />
                            </div>
                        </div>

                        {errors.name &&
                            <p className="text-red-500 text-center text-sm py-2">{errors.name[0]}</p>
                        }

                        <div className="flex justify-center">
                            <div className="flex items-center w-84 bg-gray-100 border border-gray-300 rounded-md">
                                <span className="inline-flex items-center px-4 text-gray-500 bg-gray-100">
                                    (+62)
                                </span>
                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    className="w-full px-4 py-3 bg-white border border-gray-300 rounded-r-md text-gray-700 focus:text-gray-700 focus:border-gray-300 focus:ring-1 focus:ring-gray-300 outline-none sm:text-sm"
                                    placeholder="Masukkan nomor telepon Anda"
                                    value={data.phone}
                                    onChange={(e) => setData({ ...data, phone: e.target.value })}
                                    autoComplete="off"
                                    required
                                />
                            </div>
                        </div>

                        {errors.phone &&
                            <p className="text-red-500 text-center text-sm py-2">{errors.phone[0]}</p>
                        }

                        <div className="pt-4">
                            <div className="flex justify-center pb-8 border-b border-b-gray-300">
                                <button type="submit" className="group flex items-center justify-center w-48 gap-2 rounded-lg border border-[#C60E2A] bg-[#C60E2A] px-4 py-2 cursor-pointer">
                                    <span className="font-medium text-white">
                                        Daftar
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div className="flex justify-center pt-4">
                            <p className="text-sm text-gray-600">
                                Sudah memiliki akun?{" "}
                                <a href="/login" className="font-medium text-[#C60E2A] hover:text-[#C60E2A]">
                                    Login disini
                                </a>
                            </p>
                        </div>
                    </form>
                </main>

            <Footer />
        </>
    )
}
