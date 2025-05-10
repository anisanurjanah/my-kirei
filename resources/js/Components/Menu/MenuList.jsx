import MenuItem from "@/Components/Menu/MenuItem";

export default function MenuList({ menus, onClick }) {
    return (
        <>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                {
                    menus.map((menu) => (
                        <MenuItem
                            key={ menu.id }
                            menu={ menu }
                            onClick={ onClick }
                        />
                    ))
                }
            </div>
        </>
    )
}
