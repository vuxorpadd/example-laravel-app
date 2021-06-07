import React from "react";
import PropTypes from "prop-types";
import FieldWithError from "./FieldWithError";

const FileUpload = ({
    onChange,
    error,
    label,
    buttonLabel = "Choose file",
    filename = "",
    ...rest
}) => (
    <FieldWithError error={error}>
        <div className="text-gray-600 my-2">
            {label}: <span className="">{filename || "none"}</span>
        </div>
        <label
            htmlFor="file-upload"
            className="bg-gray-500 p-2 text-white font-bold uppercase shadow-md rounded-md text-center w-full block"
        >
            <span className="">{buttonLabel}</span>
            <input
                id="file-upload"
                type="file"
                onChange={(e) => onChange(e.target.files[0])}
                className="hidden"
                {...rest}
            />
        </label>
    </FieldWithError>
);

FileUpload.propTypes = {
    onChange: PropTypes.func.isRequired,
    error: PropTypes.string,
    label: PropTypes.string.isRequired,
    buttonLabel: PropTypes.string,
    filename: PropTypes.string,
};

FileUpload.defaultProps = {
    error: null,
    buttonLabel: "Choose file",
    filename: "",
};

export default FileUpload;
