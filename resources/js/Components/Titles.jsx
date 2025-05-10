export default function Titles({ title }) {
    return (
        <>
            <span className="flex items-center py-2">
                <span className="shrink-0 pe-4">
                    <h2 className="text-xl md:text-3xl text-[#333] font-semibold">{ title }</h2>
                </span>

                <span className="h-px flex-1 bg-gray-300"></span>
            </span>
        </>
    )
}
