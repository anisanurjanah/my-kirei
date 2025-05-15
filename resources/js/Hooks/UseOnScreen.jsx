import { useEffect, useState, useRef } from "react";

export function UseOnScreen(options) {
    const ref = useRef();
    const [hasShown, setHasShown] = useState(false);

    useEffect(() => {
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting && !hasShown) {
                    setHasShown(true);
                    observer.unobserve(entry.target);
                }
            },
            options
        );

        if (ref.current) {
            observer.observe(ref.current);
        }

        return () => {
            if (ref.current) observer.unobserve(ref.current);
        };
    }, [ref, hasShown, options]);

    return [ref, hasShown];
}
