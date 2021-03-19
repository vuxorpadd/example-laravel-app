import React, { useEffect, useState } from "react";
import Hamburger from "hamburger-react";
import {
    disableBodyScroll,
    enableBodyScroll,
    clearAllBodyScrollLocks,
} from "body-scroll-lock";
import MenuItemsType from "../Types/MenuItemsType";
import HamburgerMenuSection from "./HamburgerMenuSection";

const HamburgerMenu = ({ menuItems, authMenuItems }) => {
    const [showMenu, setShowMenu] = useState(false);
    const targetElement = "none";

    useEffect(() => {
        if (showMenu) {
            disableBodyScroll(targetElement);
        } else {
            enableBodyScroll(targetElement);
        }
    }, [showMenu, targetElement]);

    useEffect(() => () => {
        clearAllBodyScrollLocks();
    });

    const closeMenu = () => {
        setShowMenu(false);
    };

    return (
        <>
            <div className="absolute right-0 top-0 px-4 py-2 z-20">
                <Hamburger toggled={showMenu} toggle={setShowMenu} />
            </div>

            {showMenu && (
                <div className="z-10">
                    <div className="bg-white fixed inset-0 opacity-95 flex" />
                    <div className="fixed inset-0 flex">
                        <div className="m-auto p-2 space-y-8 font-bold text-gray-800">
                            <div className="space-y-8 border-b-4 pb-8">
                                <HamburgerMenuSection
                                    menuItems={menuItems}
                                    onMenuItemClick={closeMenu}
                                />
                            </div>
                            <div className="space-y-8">
                                <HamburgerMenuSection
                                    menuItems={authMenuItems}
                                    onMenuItemClick={closeMenu}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
};

HamburgerMenu.propTypes = {
    menuItems: MenuItemsType.isRequired,
    authMenuItems: MenuItemsType.isRequired,
};

export default HamburgerMenu;
