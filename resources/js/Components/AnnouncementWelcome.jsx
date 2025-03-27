import { CircleX } from "lucide-react";

export default function WelcomeAnnouncement({ message, user, onClose }) {
    return (
        <>
            <div className="flex items-center justify-between border-b border-gray-200 bg-gray-100 px-4 py-2 text-gray-900">
                <span> </span>

                <p className="text-center text-sm font-medium">{message.title || `Selamat datang, ${user}!`}</p>

                <button
                    type="button"
                    aria-label="Dismiss"
                    className="p-1"
                    onClick={onClose}
                >
                    <CircleX size={16} />
                </button>
            </div>
        </>
    )
}
