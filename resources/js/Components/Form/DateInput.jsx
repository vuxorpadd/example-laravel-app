import React from "react";
import PropTypes from "prop-types";
import DatePicker from "react-datepicker";
import FieldWithError from "./FieldWithError";
import "react-datepicker/dist/react-datepicker.css";

const DateInput = ({ value, onChange, error, label }) => (
    <FieldWithError error={error}>
        <div className="date-field">
            <DatePicker
                selected={value}
                onChange={(date) => onChange(date)}
                dateFormat="yyyy-MM-dd"
                placeholderText={label}
                className="form-control"
            />
        </div>
    </FieldWithError>
);

DateInput.propTypes = {
    value: PropTypes.instanceOf(Date).isRequired,
    onChange: PropTypes.func.isRequired,
    error: PropTypes.string,
    label: PropTypes.string,
};

DateInput.defaultProps = {
    error: null,
    label: "",
};

export default DateInput;
