import { createContext, useState } from 'react';

import axios from 'axios';

export const OutletContext = createContext();

export function OutletProvider({ children }) {
    const [outlet, setOutlet] = useState(null);
    const [errors, setErrors] = useState({});

    const outlets = async () => {
        try {
            const res = await axios.get("http://my-kirei.test/api/outlets");
            setOutlet(res.data.outlets)
            setErrors({})
        } catch (error) {
            setOutlet(null);
            if (error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            } else {
                console.log({ message: error.response?.data?.message || "Terjadi kesalahan", type: "error" });
            }
        }
    }

    return (
        <OutletContext.Provider value={{ outlet, outlets, errors }}>
            {children}
        </OutletContext.Provider>
    );
}
