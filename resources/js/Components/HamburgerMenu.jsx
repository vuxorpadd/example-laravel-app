import React, { useEffect, useState } from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import Hamburger from "hamburger-react";
import PropTypes, { string } from "prop-types";
import {
    disableBodyScroll,
    enableBodyScroll,
    clearAllBodyScrollLocks,
} from "body-scroll-lock";

const HamburgerMenu = ({ menuItems }) => {
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

    return (
        <>
            <div className="absolute right-0 top-0 px-4 py-2 z-20">
                <Hamburger toggled={showMenu} toggle={setShowMenu} />
            </div>

            {showMenu && (
                <div className="z-10">
                    <div className="bg-white fixed inset-0 opacity-95 flex" />
                    <div className="fixed inset-0 flex">
                        <div className="m-auto p-2 font-bold space-y-8 text-gray-800">
                            {menuItems.map(({ href, label }) => (
                                <InertiaLink
                                    key={href}
                                    className="block text-2xl"
                                    href={href}
                                >
                                    {label}
                                </InertiaLink>
                            ))}
                        </div>
                    </div>
                </div>
            )}
        </>
    );
};

HamburgerMenu.propTypes = {
    menuItems: PropTypes.arrayOf(
        PropTypes.shape({
            href: string,
            label: string,
        })
    ).isRequired,
};

export default HamburgerMenu;
