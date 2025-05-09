import Main from "@/Layouts/Main";

import Header from "@/Components/Header";
import Titles from "@/Components/Titles";

export default function OrderDetailPage() {
    const {
        outlet_code: outletCode,
        order,
        payment,
        customer
    } = usePage().props;

    console.log(usePage().props);

    return (
        <>
            <Head title={`Ringkasan Pesanan - ${outletCode.toUpperCase()}`} />
            <Header />
            <Main>
                {/* <PaymentProgressSteps outletCode={outletCode} /> */}
                <section className="p-4">
                    <div className="bg-white w-full">

                    </div>
                </section>
            </Main>
        </>
    )
}
