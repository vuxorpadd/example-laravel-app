import React from "react";
import NavigationItem from "./NavigationItem";
import MenuItemsType from "../Types/MenuItemsType";

const Navigation = ({ menuItems }) => (
    <div className="space-x-6 text-gray-600 text-l font-bold">
        {menuItems.map(({ href, label }) => (
            <NavigationItem href={href} label={label} />
        ))}
    </div>
);

Navigation.propTypes = {
    menuItems: MenuItemsType.isRequired,
};

export default Navigation;
