import useUser from "../Hooks/useUser";

const MenuItems = ({ items, render }) => {
    const user = useUser();

    const itemsToShow = items.filter((menuItem) => {
        if (menuItem.role === "auth" && !user) {
            return false;
        }

        if (menuItem.role === "notauth" && user) {
            return false;
        }

        return true;
    });

    return itemsToShow.map((item) => {
        const data = {
            onClick: (e) => {
                if (item.action) {
                    e.preventDefault();
                    item.action();
                }
            },
            href: item.href,
            label: item.label,
        };

        return render(data);
    });
};

export default MenuItems;
