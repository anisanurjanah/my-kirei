export default function PaymentDetails({ selectedPaymentMethod, payment, paymentDetails }) {
    return (
        <>
            {
                selectedPaymentMethod ? (
                    <div className="mt-4">
                        <div className="flex justify-center items-center gap-4">
                            {
                                ( selectedPaymentMethod ) && (
                                    <img
                                        src={ `/${ selectedPaymentMethod.method.image }` }
                                        alt={ selectedPaymentMethod.method.name }
                                        className="w-auto h-4"
                                    />
                                )
                            }

                            <h3 className="text-lg md:text-xl font-semibold text-[#333] text-center">{selectedPaymentMethod.method.name}</h3>
                        </div>

                        <p className="text-sm md:text-md font-bold text-[#C60E2A] text-center my-3">{ paymentDetails?.instruction }</p>

                        {
                            ( selectedPaymentMethod.type === 'QR Code' || selectedPaymentMethod.type === 'E-Wallet') && (
                                <div className="flex justify-center my-4 text-center">
                                    <img
                                        src={ `${ payment?.qr_code_url }` }
                                        alt="QR Code"
                                        className="w-48 h-48 mx-auto"
                                    />
                                </div>
                            )
                        }

                        {
                            selectedPaymentMethod.type === 'Bank Transfer' && payment?.va_number && (
                                <div className="rounded-md shadow my-4 py-4 text-center">
                                    <p className="text-xl md:text-3xl font-bold text-[#C60E2A]">{ payment.va_number }</p>
                                    <p className="text-xs text-[#333]">Nomor Virtual Akun</p>
                                </div>
                            )
                        }

                        <div className="text-sm md:text-md text-[#333]">
                            <p className="mt-2"><strong>Jumlah: </strong>IDR { Number(payment?.amount).toLocaleString() }</p>
                            <p className="font-bold">Detail Pembayaran:</p>
                            <p>
                                {
                                    paymentDetails?.details.split('\n').map((line, idx) => (
                                        <p key={ idx }> {line }</p>
                                    ))
                                }
                            </p>
                        </div>
                    </div>
                ) : (
                    <p className="mt-4 text-center text-[#333]">Tidak ada metode pembayaran untuk dilanjutkan.</p>
                )
            }
        </>
    )
}
