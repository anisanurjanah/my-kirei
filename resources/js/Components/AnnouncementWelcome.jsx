import { XCircle } from "lucide-react";

export default function WelcomeAnnouncement({ message, customer, onClose }) {
    return (
        <>
            <div className="flex items-center justify-between border-b border-gray-200 bg-gray-100 px-4 py-2 text-gray-900">
                <span> </span>

                <p className="text-center text-sm font-medium">
                    {`${message.title} ${customer}!`}
                </p>

                <button type="button" className="bg-none p-1 cursor-pointer">
                    <XCircle size={16} onClick={onClose} />
                </button>
            </div>
        </>
    )
}
