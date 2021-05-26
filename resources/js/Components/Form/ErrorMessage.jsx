import React from "react";
import PropTypes from "prop-types";

const ErrorMessage = ({ children }) => (
    <div className="text-red-500">{children}</div>
);

ErrorMessage.propTypes = {
    children: PropTypes.node,
};

ErrorMessage.defaultProps = {
    children: undefined,
};

export default ErrorMessage;
