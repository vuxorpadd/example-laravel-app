import React from "react";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import MenuItemsType from "../Types/MenuItemsType";
import MenuItems from "./MenuItems";

const Navigation = ({ menuItems }) => {
    const { component: currentComponent } = usePage();

    return (
        <div className="space-x-6 text-gray-600 text-l font-bold">
            <MenuItems
                items={menuItems}
                render={(data) => {
                    const { href, onClick, components, label } = data;

                    return (
                        <InertiaLink
                            key={href}
                            href={href}
                            onClick={onClick}
                            className={`p-2 border-b border-transparent hover:border-gray-400 ${
                                components &&
                                components.includes(currentComponent)
                                    ? "border-gray-400"
                                    : ""
                            }`}
                        >
                            {label}
                        </InertiaLink>
                    );
                }}
            />
        </div>
    );
};

Navigation.propTypes = {
    menuItems: MenuItemsType.isRequired,
};

export default Navigation;
