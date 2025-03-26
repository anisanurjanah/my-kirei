import { Head, Link, usePage } from "@inertiajs/react";

export default function Home() {
    const { props } = usePage();
    const outletCode = props.outlet_code;

    return (
        <>
            <Head title={`Menu - ${outletCode.toUpperCase()}`} />

            <main className="max-w-screen-lg mx-auto">
                <h1>MENU PAGE</h1>
            </main>
        </>
    )
}
