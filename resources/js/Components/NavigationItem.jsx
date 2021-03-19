import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import { string } from "prop-types";

const NavigationItem = ({ href, label }) => (
    <InertiaLink className="" href={href}>
        {label}
    </InertiaLink>
);

NavigationItem.propTypes = {
    href: string.isRequired,
    label: string.isRequired,
};

export default NavigationItem;
