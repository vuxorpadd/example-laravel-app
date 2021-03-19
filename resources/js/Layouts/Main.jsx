import React from "react";
import PropTypes from "prop-types";
import { InertiaLink } from "@inertiajs/inertia-react";
import Navigation from "../Components/Navigation";
import HamburgerMenu from "../Components/HamburgerMenu";
import menuItems from "../Menu/MenuItems";

const Main = ({ children }) => (
    <>
        <header>
            <div className="fixed top-0 p-4 w-full bg-white shadow-md md:flex md:space-x-14 md:items-center">
                <h1 className="text-3xl font-bold text-red-500 font-logo">
                    <InertiaLink href="/">
                        <span className="md:hidden">BS</span>
                        <span className="hidden md:inline">Book Shelf</span>
                    </InertiaLink>
                </h1>
                <div className="md:hidden">
                    <HamburgerMenu menuItems={menuItems} />
                </div>
                <div className="hidden md:block">
                    <Navigation menuItems={menuItems} />
                </div>
            </div>
        </header>

        <div className="px-4 mt-20 container mx-auto">{children}</div>
    </>
);

Main.propTypes = {
    children: PropTypes.node,
};

Main.defaultProps = {
    children: undefined,
};

export default Main;
