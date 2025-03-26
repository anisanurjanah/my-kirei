import { Head, Link, usePage } from "@inertiajs/react";

export default function Home() {
    const { component } = usePage()

    return (
        <>
            <Head title={component} />

            <main className="max-w-screen-lg mx-auto">
                <h1>MENU PAGE</h1>
            </main>
        </>
    )
}
