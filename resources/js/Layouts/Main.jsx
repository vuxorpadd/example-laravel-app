import React from "react";
import PropTypes from "prop-types";
import { InertiaLink } from "@inertiajs/inertia-react";
import Navigation from "../Components/Navigation";
import HamburgerMenu from "../Components/HamburgerMenu";
import menuItems from "../Menu/MenuItems";
import authMenuItems from "../Menu/AuthMenuItems";
import useUser from "../Hooks/useUser";
import WishlistMenuItem from "../Components/WishlistMenuItem";
import ProfileMenuItem from "../Components/ProfileMenuItem";

const Main = ({ children }) => {
    const user = useUser();

    return (
        <>
            <header>
                <div className="fixed top-0 p-4 w-full bg-white shadow-md z-10">
                    <div className="w-full relative">
                        <div className="flex mr-14 md:mr-0 items-center">
                            <h1 className="text-3xl font-bold text-red-500 font-logo">
                                <InertiaLink href="/">
                                    <span className="md:hidden">BS</span>
                                    <span className="hidden md:inline">
                                        Book Shelf
                                    </span>
                                </InertiaLink>
                            </h1>

                            <div className="hidden md:block ml-20">
                                <Navigation menuItems={menuItems} />
                            </div>

                            <div className="ml-auto flex items-center space-x-4">
                                {user && (
                                    <>
                                        <div className="hidden md:block">
                                            <ProfileMenuItem user={user} />
                                        </div>
                                        <div>
                                            <WishlistMenuItem />
                                        </div>
                                    </>
                                )}
                                <div className="hidden md:inline-flex">
                                    <Navigation
                                        menuItems={authMenuItems.filter(
                                            (item) => item.id !== "logout"
                                        )}
                                    />
                                </div>
                            </div>
                        </div>

                        <div className="md:hidden">
                            <HamburgerMenu
                                menuItems={menuItems}
                                authMenuItems={authMenuItems}
                            />
                        </div>
                    </div>
                </div>
            </header>

            <div className="px-4 py-2 mt-24 container mx-auto">{children}</div>
        </>
    );
};

Main.propTypes = {
    children: PropTypes.node,
};

Main.defaultProps = {
    children: undefined,
};

export default Main;
