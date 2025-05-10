import CartItem from "@/Components/Cart/CartItem";

export default function CartList({ menus, quantities, onIncrease, onDecrease, onRemove }) {
    return (
        <>
            {
                menus.length === 0 ? (
                    <div className="flex justify-center py-3 border-b border-gray-300">
                        <p className="text-[#333] text-center">Belum ada menu yang dipilih.</p>
                    </div>
                ) : (
                    <ul className="space-y-4">
                        {
                            menus.map((menu, index) => {
                                return (
                                    <CartItem
                                        key={ index }
                                        menu={ menu }
                                        quantities={ quantities[menu.id] || 1 }
                                        onIncrease={ () => onIncrease(menu.id) }
                                        onDecrease={ () => onDecrease(menu.id) }
                                        onRemove={ () => onRemove(menu.id) }
                                    />
                                );
                            }
                        )}
                    </ul>
                )
            }
        </>
    )
}
