import { Head, usePage } from "@inertiajs/react";

import Header from "@/Layouts/Header";
import Jumbotron from "@/Layouts/Jumbotron";
import Footer from "@/Layouts/Footer";

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

                <main className="max-w-screen-lg mx-4 md:mx-auto">
                    <section id="about" className="h-screen flex flex-col justify-center items-center bg-blue-100 text-center">
                        <h2 className="text-4xl font-bold">Tentang Kirei Sum</h2>
                        <p className="text-gray-700 mt-4">Kirei Sum adalah tempat terbaik untuk menikmati hidangan lezat.</p>
                    </section>

                    <section id="menu" className="h-screen flex flex-col justify-center items-center bg-green-100 text-center">
                        <h2 className="text-4xl font-bold">Menu</h2>
                        <p className="text-gray-700 mt-4">Kami menyajikan berbagai pilihan makanan berkualitas tinggi.</p>
                    </section>

                    <section id="location" className="h-screen flex flex-col justify-center items-center bg-yellow-100 text-center">
                        <h2 className="text-4xl font-bold">Lokasi</h2>
                        <p className="text-gray-700 mt-4">Temukan kami di berbagai lokasi strategis.</p>
                    </section>

                    <section id="contact" className="h-screen flex flex-col justify-center items-center bg-red-100 text-center">
                        <h2 className="text-4xl font-bold">Kontak</h2>
                        <p className="text-gray-700 mt-4">Hubungi kami untuk reservasi atau informasi lebih lanjut.</p>
                    </section>
                </main>

            <Footer />
        </>
    )
}
