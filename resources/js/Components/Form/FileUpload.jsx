import React from "react";
import PropTypes from "prop-types";
import FieldWithError from "./FieldWithError";

const FileUpload = ({ onChange, error, label, filename = "", ...rest }) => (
    <FieldWithError error={error}>
        <div className="text-gray-600 my-2">
            {label}: <span className="">{filename || "none"}</span>
        </div>
        <div className="bg-gray-500 text-white p-2 font-bold uppercase shadow-md rounded-md text-center w-full">
            <label htmlFor="file-upload">
                <span className="">Choose file</span>
                <input
                    id="file-upload"
                    type="file"
                    onChange={(e) => onChange(e.target.files[0])}
                    className="hidden"
                    {...rest}
                />
            </label>
        </div>
    </FieldWithError>
);

FileUpload.propTypes = {
    onChange: PropTypes.func.isRequired,
    error: PropTypes.string,
    label: PropTypes.string.isRequired,
    filename: PropTypes.string,
};

FileUpload.defaultProps = {
    error: null,
    filename: "",
};

export default FileUpload;
