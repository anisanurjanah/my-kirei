import { Head, usePage } from "@inertiajs/react";

import Header from "@/Components/Header";
import Jumbotron from "@/Components/Jumbotron";

export default function Home() {
    const { component } = usePage()

    const handleScroll = (id) => {
        const element = document.getElementById(id);
        if (element) {
            element.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    }

    return (
        <>
            <Head title={component} />

            <Header handleScroll={handleScroll} />
            <Jumbotron />

            <main className="w-4/5 mx-auto p-8">
                <div id="about" className="h-screen flex items-center justify-center bg-blue-100">
                    <h2>Tentang Kirei Sum</h2>
                </div>
                <div id="menu" className="h-screen flex items-center justify-center bg-green-100">
                    <h2>Menu</h2>
                </div>
                <div id="location" className="h-screen flex items-center justify-center bg-yellow-100">
                    <h2>Lokasi</h2>
                </div>
                <div id="contact" className="h-screen flex items-center justify-center bg-red-100">
                    <h2>Kontak</h2>
                </div>
            </main>
        </>
    )
}
