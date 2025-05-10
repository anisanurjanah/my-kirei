import { useEffect, useState } from "react";

const PaymentCountdownTimer = ({ expiryTime }) => {
    const [timeLeft, setTimeLeft] = useState("");

    useEffect(() => {
    const countdown = setInterval(() => {
        const now = new Date();
        const expiry = new Date(expiryTime);
        const diff = expiry - now;

        if (diff <= 0) {
            clearInterval(countdown);
            setTimeLeft("Waktu habis");
            return;
        }

        const minutes = Math.floor((diff / 1000 / 60) % 60);
        const seconds = Math.floor((diff / 1000) % 60);
        const hours = Math.floor((diff / 1000 / 60 / 60) % 24);

        setTimeLeft(
            `${hours.toString().padStart(2, "0")}:${minutes
                .toString()
                .padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`
            );
        }, 1000);

        return () => clearInterval(countdown);
    }, [expiryTime]);

    return (
        <div className="flex justify-center py-3">
            <div className="p-3 rounded-lg w-fit">
                <p className="text-sm md:text-md text-[#333] text-center font-semibold">
                Selesaikan pembayaran sebelum:{" "}
                <span className="ml-1 font-mono text-[#C60E2A] text-2xl tracking-wide">
                    { timeLeft }
                </span>
                </p>
            </div>
        </div>
    );
};

export default PaymentCountdownTimer;
