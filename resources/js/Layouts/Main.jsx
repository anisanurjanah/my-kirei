import Footer from "@/Layouts/Footer";

export default function Main({ children }) {
    return (
        <>
            <div className="flex flex-col">
                <main className="max-w-screen-lg w-full h-auto mx-auto">
                    {children}
                </main>

                <Footer />
            </div>
        </>
    );
}
