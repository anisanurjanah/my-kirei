import { Head, usePage } from "@inertiajs/react";

import Header from "@/Layouts/Header";
import Hero from "@/Layouts/Hero";
import Main from "@/Layouts/Main";

import About from "@/Layouts/Home/About";
import Menu from "@/Layouts/Home/Menu";
import Location from "@/Layouts/Home/location";
import Order from "@/Layouts/Home/Order";
import Contact from "@/Layouts/Home/Contact";

export default function Home() {
    const {
        outlets,
        menus
    } = usePage().props;

    const handleScroll = (id) => {
        const element = document.getElementById(id);
        if (element) {
            element.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    }

    return (
        <>
            <Head title="Kirei Sum" />
            <Header
                handleScroll={ handleScroll }
                outlets={ outlets }
            />
            <Hero />
            <Main>
                <About />
                <Menu menus={ menus }/>
                <Location outlets={ outlets } />
                <Order outlets={outlets} />
                <Contact />
            </Main>
        </>
    )
}
