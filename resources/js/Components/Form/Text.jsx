import React from "react";
import PropTypes from "prop-types";
import FieldWithError from "./FieldWithError";

const Text = ({ value, onChange, error, label = "", ...rest }) => (
    <FieldWithError error={error}>
        <textarea
            value={value}
            onChange={(e) => onChange(e.target.value)}
            placeholder={label}
            className="form-control"
            {...rest}
        />
    </FieldWithError>
);

Text.propTypes = {
    value: PropTypes.string.isRequired,
    onChange: PropTypes.func.isRequired,
    error: PropTypes.string,
    label: PropTypes.string,
};

Text.defaultProps = {
    error: null,
    label: "",
};

export default Text;
