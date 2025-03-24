import { Inertia } from '@inertiajs/inertia';
import { createContext, useState } from "react";

import axios from "axios";

export const AuthContext = createContext();

export function AuthProvider({ children }) {
    const [user, setUser] = useState(null);
    const [token, setToken] = useState(localStorage.getItem("token") || "");
    const [errors, setErrors] = useState({});
    const [alert, setAlert] = useState(() => {
        const savedAlert = localStorage.getItem("alert");
        return savedAlert ? JSON.parse(savedAlert) : null;
    });

    const register = async (formData) => {
        try {
            const res = await axios.post("http://my-kirei.test/api/register", formData);
            setToken(res.data.token);
            localStorage.setItem("token", res.data.token);
            setUser(res.data.customer);
            setErrors({});

            // Set alert
            const alertData = { message: "Terima kasih, akun Anda telah berhasil terdaftar.", type: "success" };
            setAlert(alertData);
            localStorage.setItem("alert", JSON.stringify(alertData));

            setTimeout(() => {
                Inertia.visit("/login");
            }, 2000);
        } catch (error) {
            if (error.response?.data?.message === "Duplicate entry") {
                setAlert({ message: "Nomor telepon sudah terdaftar, silakan masukkan nomor lain.", type: "error" });
                setErrors({});
            } else if (error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            } else {
                setAlert({ message: error.response?.data?.message || "Terjadi kesalahan", type: "error" });
            }
        }
    };

    return (
        <AuthContext.Provider value={{ user, token, register, alert, errors }}>
            {children}
        </AuthContext.Provider>
    );
}
