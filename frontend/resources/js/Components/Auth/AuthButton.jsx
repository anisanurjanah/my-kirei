import { Link } from "@inertiajs/react";

export default function AuthButton({ type, outletCode }) {
    const isLogin = type === "login";

    return (
        <div className="flex justify-center">
            <p className="text-sm text-gray-600">
                { isLogin ? "Belum memiliki akun?" : "Sudah memiliki akun?" }{" "}
                <Link
                    href={ `/${outletCode}/${isLogin ? "register" : "login" }` }
                    className="font-medium text-[#C60E2A] hover:text-[#C60E2A]"
                >
                    { isLogin ? "Daftar sekarang" : "Masuk di sini" }
                </Link>
            </p>
        </div>
    )
}
