import React from "react";
import Loader from "react-loader-spinner";
import PropTypes from "prop-types";

const SubmitButton = ({ isProcessing, children }) => (
    <button
        type="submit"
        disabled={isProcessing}
        className="btn btn-primary h-10"
    >
        {!isProcessing ? (
            <>{children}</>
        ) : (
            <Loader
                className="inline-block"
                type="TailSpin"
                height={20}
                width={30}
                color="white"
            />
        )}
    </button>
);

SubmitButton.propTypes = {
    isProcessing: PropTypes.bool.isRequired,
    children: PropTypes.node.isRequired,
};

export default SubmitButton;
