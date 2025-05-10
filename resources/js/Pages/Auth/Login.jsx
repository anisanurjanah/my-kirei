import { useEffect, useState } from "react";
import { Head, usePage, useForm } from "@inertiajs/react";

import Jumbotron from "@/Layouts/Jumbotron";
import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import AuthLoginForm from "@/Components/Auth/AuthLoginForm";
import AuthLoginAlert from "@/Components/Auth/AuthLoginAlert";
import AuthButton from "@/Components/Auth/AuthButton";

export default function Login() {
    const { outlet_code: outletCode, flash } = usePage().props;

    // Handle data
    const { data, setData, post, errors } = useForm({
        phone: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        const formData = { phone: data.phone };
        post(`/${outletCode}/login`, formData);
    };

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
                    <AuthLoginAlert
                        flashMsg={ flashMsg }
                        dismissFlash={ dismissFlash }
                    />
                    <AuthLoginForm
                        onSubmit={ handleSubmit }
                        onChange={ handlePhoneChange }
                        errors={ errors }
                        data={ data }
                    />
                </section>
                <hr className="mt-8 mb-4 border border-gray-300" />
                <AuthButton type="login" outletCode={ outletCode } />
            </Main>
        </>
    )
}
