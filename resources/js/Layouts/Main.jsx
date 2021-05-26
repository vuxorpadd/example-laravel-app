import React from "react";
import PropTypes from "prop-types";
import { InertiaLink } from "@inertiajs/inertia-react";
import Navigation from "../Components/Navigation";
import HamburgerMenu from "../Components/HamburgerMenu";
import menuItems from "../Menu/MenuItems";
import authMenuItems from "../Menu/AuthMenuItems";
import useUser from "../Hooks/useUser";
import ProfileAvatar from "../Components/ProfileAvatar";

const Main = ({ children }) => {
    const user = useUser();

    return (
        <>
            <header>
                <div className="fixed top-0 p-4 w-full bg-white shadow-md flex md:items-center">
                    <h1 className="text-3xl font-bold text-red-500 font-logo">
                        <InertiaLink href="/">
                            <span className="md:hidden">BS</span>
                            <span className="hidden md:inline">Book Shelf</span>
                        </InertiaLink>
                    </h1>

                    <div className="hidden md:block ml-20">
                        <Navigation menuItems={menuItems} />
                    </div>

                    <div className="ml-auto flex items-center space-x-4">
                        {user && (
                            <>
                                <div className="inline-flex mr-16 md:mr-auto">
                                    <ProfileAvatar user={user} />
                                </div>
                            </>
                        )}
                        <div className="hidden md:inline-flex">
                            <Navigation menuItems={authMenuItems} />
                        </div>
                    </div>

                    <div className="md:hidden">
                        <HamburgerMenu
                            menuItems={menuItems}
                            authMenuItems={authMenuItems}
                        />
                    </div>
                </div>
            </header>

            <div className="px-4 py-2 mt-20 container mx-auto">{children}</div>
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
