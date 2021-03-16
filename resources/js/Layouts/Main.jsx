import React from "react";
import PropTypes from "prop-types";

const Main = ({ children }) => (
    <div>
        <div className="lg:w-2/3 w-full mx-auto px-4 py-2">{children}</div>
    </div>
);

Main.propTypes = {
    children: PropTypes.node,
};

Main.defaultProps = {
    children: undefined,
};

export default Main;
