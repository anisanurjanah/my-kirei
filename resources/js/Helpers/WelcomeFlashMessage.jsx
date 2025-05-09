import { useEffect, useState } from "react";

export default function WelcomeFlashMessage(flash, customer) {
    const storedFlash = sessionStorage.getItem("flashMessage");

    const [flashMsg, setFlashMsg] = useState(flash.success && !storedFlash ? flash.success : null);
    useEffect(() => {
        if (flash && storedFlash !== "dismissed") {
            setFlashMsg(flash.success);
            sessionStorage.setItem("flashMessage", "shown");
        }

        const customerId = customer?.id;
        if (customerId) {
            sessionStorage.removeItem("flashMessage");
        }
    }, [flash, storedFlash, customer]);

    // Close flash message
    const dismissFlash = () => {
        setFlashMsg(null);
        sessionStorage.setItem("flashMessage", "dismissed");
    };

    return { flashMsg, dismissFlash };
}
