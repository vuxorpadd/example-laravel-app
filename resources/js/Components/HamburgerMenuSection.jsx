import React from "react";
import PropTypes from "prop-types";
import { InertiaLink } from "@inertiajs/inertia-react";
import MenuItems from "./MenuItems";
import MenuItemsType from "../Types/MenuItemsType";

const HamburgerMenuSection = ({ menuItems, onMenuItemClick }) => (
    <MenuItems
        items={menuItems}
        render={(data) => (
            <InertiaLink
                className="block text-2xl"
                href={data.href}
                onClick={(e) => {
                    data.onClick(e);
                    onMenuItemClick();
                }}
            >
                {data.label}
            </InertiaLink>
        )}
    />
);

HamburgerMenuSection.propTypes = {
    menuItems: MenuItemsType.isRequired,
    onMenuItemClick: PropTypes.func,
};

HamburgerMenuSection.defaultProps = {
    onMenuItemClick: () => {},
};

export default HamburgerMenuSection;
