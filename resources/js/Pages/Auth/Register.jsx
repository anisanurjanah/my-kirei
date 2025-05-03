import { useEffect, useState } from "react";
import { Head, usePage, useForm } from "@inertiajs/react";

import Jumbotron from "@/Layouts/Jumbotron";
import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import AuthRegisterForm from "@/Components/Auth/AuthRegisterForm";
import AuthRegisterAlert from "@/Components/Auth/AuthRegisterAlert";
import AuthButton from "@/Components/Auth/AuthButton";

export default function Register() {
    const { outlet_code: outletCode, flash } = usePage().props;

    // Alert
    const [flashMsg, setFlashMsg] = useState(flash);
    useEffect(() => {
        if (flash) {
            setFlashMsg(flash);
        }
    }, [flash]);

    // Handle data
    const { data, setData, post, errors } = useForm({
        name: "",
        phone: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        const formData = { name: data.name, phone: data.phone };
        post(`/${outletCode}/register`, formData);
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
            <Head title={`Daftar - ${outletCode.toUpperCase()}`} />
            <Header />
            <Jumbotron />
            <Main>
                <section className="w-84 mx-auto flex flex-col items-center">
                    <AuthRegisterAlert
                        flashMsg={ flashMsg }
                    />
                    <AuthRegisterForm
                        onSubmit={ handleSubmit }
                        onChange={ handlePhoneChange }
                        errors={ errors }
                        data={ data }
                        setData={ setData }
                    />
                </section>
                <hr className="mt-8 mb-4 border border-gray-300" />
                <AuthButton type="register" outletCode={ outletCode } />
            </Main>
        </>
    )
}
