import React from "react";
import PropTypes from "prop-types";
import FieldWithError from "./FieldWithError";

const Select = ({ value, onChange, error, options = [] }) => (
    <FieldWithError error={error}>
        <select
            value={value}
            onChange={(e) => onChange(e.target.value)}
            className="border-gray-300 rounded focus:outline-none focus:ring-blue-300 focus:ring-2 focus:border-transparent w-full"
        >
            {options.map((option) => (
                <option key={option.value} value={option.value}>
                    {option.label}
                </option>
            ))}
        </select>
    </FieldWithError>
);

Select.propTypes = {
    value: PropTypes.string.isRequired,
    onChange: PropTypes.func.isRequired,
    error: PropTypes.string,
    options: PropTypes.arrayOf(
        PropTypes.shape({
            value: PropTypes.number,
            label: PropTypes.string,
        })
    ),
};

Select.defaultProps = {
    error: null,
    options: [],
};

export default Select;
