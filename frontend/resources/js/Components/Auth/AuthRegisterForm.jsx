export default function AuthRegisterForm({ onSubmit, onChange, errors, data, setData }) {
    return (
        <>
            <form onSubmit={ onSubmit }>
                <div className="flex justify-center mb-6 mx-8">
                    <div className="flex items-center w-full md:w-84 bg-gray-100 border border-gray-300 rounded-md">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            className={ `w-full px-4 py-2 md:py-3 bg-white border rounded-r-md text-gray-700 focus:text-gray-700 focus:ring-1 outline-none sm:text-sm
                                ${ errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-gray-300 focus:ring-gray-300' }` }
                            placeholder="Masukkan nama lengkap Anda"
                            value={ data.name }
                            onChange={ (e) => setData({ ...data, name: e.target.value }) }
                            autoComplete="off"
                            required
                        />
                    </div>
                </div>

                {
                    errors.name &&
                        <p className="text-red-500 text-center text-sm py-2">{ errors.name }</p>
                }

                <div className="flex justify-center mb-6 mx-8">
                    <div className="flex items-center w-full md:w-84 bg-gray-100 border border-gray-300 rounded-md">
                        <span className="inline-flex items-center px-3 md:px-4 text-gray-500 bg-gray-100">
                            (+62)
                        </span>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            className={ `w-full px-4 py-2 md:py-3 bg-white border rounded-r-md text-gray-700 focus:text-gray-700 focus:ring-1 outline-none sm:text-sm
                                ${ errors.phone ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-gray-300 focus:ring-gray-300' }` }
                            placeholder="Masukkan nomor telepon Anda"
                            value={ data.phone }
                            onChange={ onChange }
                            autoComplete="off"
                            required
                        />
                    </div>
                </div>

                {
                    errors.phone &&
                        <p className="text-red-500 text-center text-sm py-2">{ errors.phone }</p>
                }

                <div className="flex justify-center mx-8">
                    <button type="submit" className="group flex items-center justify-center w-full md:w-84 gap-2 rounded-lg border border-[#C60E2A] bg-[#C60E2A] px-4 py-2 cursor-pointer">
                        <span className="font-medium text-white">
                            Daftar
                        </span>
                    </button>
                </div>
            </form>
        </>
    )
}
