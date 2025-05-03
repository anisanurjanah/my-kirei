import ErrorAlert from "@/Components/AlertError";

export default function AuthRegisterAlert({ flashMsg }) {
    return (
        <>
            <div className="flex justify-center md:w-84 mx-8 py-4">
                {
                    flashMsg?.error && (
                        <ErrorAlert
                            message={ { title: "Ups! Akun Anda tidak dapat didaftarkan", body: flashMsg.error } }
                        />
                    )
                }
            </div>
        </>
    )
}
