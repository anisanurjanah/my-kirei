export default function About() {
    return (
        <>
            <section id="about" className="h-auto scroll-mt-24 flex flex-col justify-center items-center">
                <div className="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 gap-4 md:grid-cols-2 md:items-center md:gap-8">
                        <div className="flex justify-center order-first md:order-last animate-slide-in-right">
                            <img
                                src="/img/logo-kirei-sum.jpg"
                                className="rounded w-auto h-64 lg:h-auto"
                                alt="Logo Kirei Sum"
                            />
                        </div>

                        <div className="max-w-lg md:max-w-none animate-slide-in-left">
                            <h2 className="text-xl font-bold text-gray-900 sm:text-3xl text-center md:text-left">
                                Tentang Kami
                            </h2>

                            <p className="mt-4 text-gray-500 text-justify">
                                Kirei Sum merupakan sebuah brand yang didedikasikan untuk memberikan
                                pengalaman kuliner yang istimewa melalui hidangan dimsum berkualitas.
                                Kami juga telah melayani konsumen selama beberapa tahun terakhir sejak
                                pandemi, dan kami berkomitmen untuk melanjutkan dan meningkatkan layanan
                                kami dalam memperkenalkan konsep dimsum yang sehat namun tetap nikmat
                                kepada pasar kuliner yang semakin berkembang.
                            </p>

                            <p className="mt-4 text-gray-500 text-justify">
                                Dengan semangat untuk terus berinovasi dan menghadirkan hidangan
                                berkualitas, Kirei Sum berkomitmen menjadi bagian dari perjalanan kuliner
                                setiap penikmatnya. Kami percaya bahwa pilihan yang sehat tidak harus
                                mengorbankan kenikmatan rasa. Terima kasih atas kepercayaan yang telah
                                menjadi inspirasi bagi kami untuk terus berkembang. Kirei Sum siap
                                melangkah lebih jauh, menghadirkan cita rasa yang sehat, nikmat, dan
                                penuh kehangatan di setiap hidangan.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </>
    )
}
