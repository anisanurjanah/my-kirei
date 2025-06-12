import MenuItem from "@/Components/Menu/MenuItem";

export default function MenuList({ menus, onClickDetail, onClick }) {
    return (
        <>
            <div className="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                {
                    menus.map((menu) => (
                        <MenuItem
                            key={ menu.id }
                            menu={ menu }
                            onClickDetail={ () => onClickDetail(menu) }
                            onClick={ onClick }
                        />
                    ))
                }
            </div>
        </>
    )
}
