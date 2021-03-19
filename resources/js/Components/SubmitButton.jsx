import React from "react";
import Loader from "react-loader-spinner";
import PropTypes, { bool, node } from "prop-types";

const SubmitButton = ({ isProcessing, children }) => (
    <button
        type="submit"
        disabled={isProcessing}
        className="p-2 bg-green-300 rounded shadow-md disabled:opacity-50 h-10 hover:bg-green-100"
    >
        {!isProcessing ? (
            <>{children}</>
        ) : (
            <Loader type="TailSpin" height={20} width={30} color="black" />
        )}
    </button>
);

SubmitButton.propTypes = {
    isProcessing: bool.isRequired,
    children: PropTypes.arrayOf(node).isRequired,
};

export default SubmitButton;
