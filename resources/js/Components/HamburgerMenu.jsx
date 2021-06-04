import React, { useEffect, useState } from "react";
import Hamburger from "hamburger-react";
import {
    disableBodyScroll,
    enableBodyScroll,
    clearAllBodyScrollLocks,
} from "body-scroll-lock";
import MenuItemsType from "../Types/MenuItemsType";
import HamburgerMenuSection from "./HamburgerMenuSection";
import ProfileCard from "./ProfileCard";
import useUser from "../Hooks/useUser";

const HamburgerMenu = ({ menuItems, authMenuItems }) => {
    const [showMenu, setShowMenu] = useState(false);
    const targetElement = "none";

    const user = useUser();

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
            <div className="absolute right-0 top-1 z-20">
                <Hamburger toggled={showMenu} toggle={setShowMenu} />
            </div>

            {showMenu && (
                <div className="z-10">
                    <div className="bg-white fixed inset-0 flex" />
                    <div className="fixed inset-0 flex">
                        <div className="m-auto p-10 space-y-8 text-gray-800 w-full h-full mt-16">
                            {user && (
                                <div className="border-b pb-8">
                                    <ProfileCard user={user} />
                                </div>
                            )}
                            <div className="space-y-8 border-b pb-8">
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
