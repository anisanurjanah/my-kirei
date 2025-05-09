export default function Header() {
    return (
        <>
            <header className="bg-white shadow-md top-0 left-0 w-full z-50">
                <div className="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
                    <div className="flex h-16 items-center justify-center">
                        <div className="md:flex md:items-center md:gap-12">
                            <h1 className="text-2xl md:text-3xl font-bold mx-2 md:mx-4">
                                KIREI <span className="text-[#C60E2A]">SUM</span>
                            </h1>
                        </div>
                    </div>
                </div>
            </header>
        </>
    );
}
