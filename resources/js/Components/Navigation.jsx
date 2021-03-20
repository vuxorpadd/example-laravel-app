import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import MenuItemsType from "../Types/MenuItemsType";
import MenuItems from "./MenuItems";

const Navigation = ({ menuItems }) => (
    <div className="space-x-6 text-gray-600 text-l font-bold">
        <MenuItems
            items={menuItems}
            render={(data) => (
                <InertiaLink
                    key={data.href}
                    href={data.href}
                    onClick={data.onClick}
                >
                    {data.label}
                </InertiaLink>
            )}
        />
    </div>
);

Navigation.propTypes = {
    menuItems: MenuItemsType.isRequired,
};

export default Navigation;
