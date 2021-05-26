import React from "react";
import PropTypes from "prop-types";
import ErrorMessage from "./ErrorMessage";

const FieldWithError = ({ children, error }) => (
    <div className={`p-2 ${error ? "bg-red-50" : ""}`}>
        {error && (
            <div className="mb-2">
                <ErrorMessage>{error}</ErrorMessage>
            </div>
        )}
        {children}
    </div>
);

FieldWithError.propTypes = {
    error: PropTypes.string,
    children: PropTypes.node,
};

FieldWithError.defaultProps = {
    children: undefined,
    error: null,
};

export default FieldWithError;
