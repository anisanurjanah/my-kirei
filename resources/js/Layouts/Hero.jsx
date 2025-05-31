export default function Hero() {
    return (
        <>
            <div className="max-w-screen-xl mx-auto mt-16 animate-slide-up">
                <div
                    className="hero h-[240px] md:min-h-screen"
                    style={{
                        backgroundImage: "url('/img/carousel-1.png')",
                        backgroundSize: 'cover',
                        backgroundPosition: 'center',
                        backgroundRepeat: 'no-repeat',
                    }}
                ></div>
            </div>
        </>
    );
}
