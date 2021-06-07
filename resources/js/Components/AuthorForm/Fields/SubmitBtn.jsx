import React, { useContext } from "react";
import PropTypes from "prop-types";
import AuthorFormContext from "../../../Context/AuthorFormContext";
import SubmitButton from "../../Form/SubmitButton";

const SubmitBtn = ({ children }) => {
    const { processing } = useContext(AuthorFormContext);

    return (
        <div className="mx-2">
            <SubmitButton isProcessing={processing}>{children}</SubmitButton>
        </div>
    );
};

SubmitBtn.propTypes = {
    children: PropTypes.node,
};

SubmitBtn.defaultProps = {
    children: undefined,
};

export default SubmitBtn;
