import React, { useContext } from "react";
import PropTypes from "prop-types";
import BookFormContext from "../../Context/BookFormContext";

const Body = ({ children }) => {
    const { submit } = useContext(BookFormContext);

    return (
        <form onSubmit={submit} className="space-y-2">
            {children}
        </form>
    );
};

Body.propTypes = {
    children: PropTypes.node,
};

Body.defaultProps = {
    children: undefined,
};

export default Body;
