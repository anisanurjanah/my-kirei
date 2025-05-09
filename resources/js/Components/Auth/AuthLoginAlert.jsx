import ErrorAlert from "@/Components/AlertError";
import SuccessAlert from "@/Components/AlertSuccess";

export default function AuthLoginAlert({ flashMsg, dismissFlash }) {
    return (
        <>
            <div className="flex justify-center md:w-84 mx-8 py-4">
                { flashMsg?.success && (
                    <SuccessAlert
                        message={ { title: flashMsg.success, body: "Pendaftaran akun Anda telah berhasil. Silakan masuk untuk melanjutkan." } }
                        onClose={ dismissFlash }
                    />
                )}

                { flashMsg?.logout_success && (
                    <SuccessAlert
                        message={ { title: flashMsg.logout_success, body: "" } }
                        onClose={ dismissFlash }
                    />
                )}

                { flashMsg?.error && (
                    <ErrorAlert
                        message={ { title: "Ups! Anda tidak dapat masuk", body: flashMsg.error } }
                    />
                )}
            </div>
        </>
    )
}
