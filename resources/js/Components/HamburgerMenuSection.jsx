import React from "react";
import PropTypes from "prop-types";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import MenuItems from "./MenuItems";
import MenuItemsType from "../Types/MenuItemsType";

const HamburgerMenuSection = ({ menuItems, onMenuItemClick }) => {
    const { component: currentComponent } = usePage();

    return (
        <MenuItems
            items={menuItems}
            render={(data) => {
                const { href, label, components, onClick } = data;

                return (
                    <InertiaLink
                        key={href}
                        className={`block text-xl p-2 ${
                            components && components.includes(currentComponent)
                                ? "border-l-8 bg-gray-100"
                                : ""
                        }`}
                        href={href}
                        onClick={(e) => {
                            onClick(e);
                            onMenuItemClick();
                        }}
                    >
                        {label}
                    </InertiaLink>
                );
            }}
        />
    );
};

HamburgerMenuSection.propTypes = {
    menuItems: MenuItemsType.isRequired,
    onMenuItemClick: PropTypes.func,
};

HamburgerMenuSection.defaultProps = {
    onMenuItemClick: () => {},
};

export default HamburgerMenuSection;
