import { TriangleAlert } from "lucide-react";

export default function ErrorAlert({ message }) {
    return (
        <>
            <div role="alert" className="border-s-4 border-red-700 bg-red-50 p-4">
                <div className="flex items-center gap-2 text-red-700">
                    <TriangleAlert size={24} className="text-white" fill="#dc2626" />

                    <strong className="font-medium">{message?.title || "Terjadi kesalahan"}</strong>
                </div>

                <p className="mt-2 text-sm text-red-700">{message?.body || "Telah terjadi kesalahan, coba lagi."}</p>
            </div>
        </>
    )
}
