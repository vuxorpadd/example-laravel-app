import React, { useContext } from "react";
import PropTypes from "prop-types";
import AuthorFormContext from "../../Context/AuthorFormContext";

const Header = ({ children }) => {
    const {
        data: { name },
    } = useContext(AuthorFormContext);

    return (
        <h3 className="mx-2 mb-2 text-3xl text-center md:text-left">
            {children ?? name}
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
