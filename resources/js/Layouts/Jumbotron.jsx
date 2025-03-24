export default function Jumbotron() {
    return (
        <>
            <div className="w-screen mt-32 mb-16 px-32">
                <div className="relative flex items-center justify-center h-[200px] bg-[#C60E2A] overflow-visible rounded-2xl">
                    <img src="/img/logo-kirei-sum.jpg" className="h-full mx-32 object-contain" alt="Logo Kirei Sum" />
                    <img src="/img/logo-kirei-sum.jpg" className="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 h-[270px] object-contain border-2 border-[#C60E2A] z-10" alt="Logo Kirei Sum" />
                    <img src="/img/logo-kirei-sum.jpg" className="h-full mx-32 object-contain" alt="Logo Kirei Sum" />
                </div>
            </div>
        </>
    );
}
