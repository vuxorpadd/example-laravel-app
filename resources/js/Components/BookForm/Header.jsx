import React, { useContext } from "react";
import PropTypes from "prop-types";
import BookFormContext from "../../Context/BookFormContext";

const Header = ({ children }) => {
    const {
        data: { title },
    } = useContext(BookFormContext);

    return (
        <h3 className="mx-2 mb-2 text-3xl text-center md:text-left">
            {children ?? title}
        </h3>
    );
};

Header.propTypes = {
    children: PropTypes.node,
};

Header.defaultProps = {
    children: undefined,
};

export default Header;
