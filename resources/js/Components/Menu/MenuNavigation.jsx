export default function MenuNavigation() {
    return (
        <>
            <div className="flex justify-center bg-gray-200 w-full">
                <div className="flex space-x-4 py-4 overflow-x-auto">
                    <button className="bg-red-500 text-white text-sm md:text-lg px-4 py-2 rounded">For You</button>
                    <button className="bg-gray-300 px-4 py-2 text-[#333] text-sm md:text-xl rounded">New Menu</button>
                    <button className="bg-gray-300 px-4 py-2 text-[#333] text-sm md:text-xl rounded">Chizu Series</button>
                </div>
            </div>
        </>
    )
}
