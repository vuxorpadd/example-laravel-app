import React from "react";
import { string } from "prop-types";

const FormInput = ({ error, ...rest }) => (
    <div>
        {error && <div className="text-red-300">{error}</div>}
        <input
            {...rest}
            className="rounded border-gray-300 focus:outline-none focus:ring-blue-300 focus:ring-2 focus:border-transparent"
            type="text"
        />
    </div>
);

FormInput.propTypes = {
    error: string.isRequired,
};

export default FormInput;
