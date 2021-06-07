import React from "react";
import { useForm } from "@inertiajs/inertia-react";
import PropTypes from "prop-types";
import AuthorFormContext from "../../Context/AuthorFormContext";
import useUploadPreview from "../../Hooks/useUploadPreview";
import AuthorType from "../../Types/AuthorType";
import Header from "./Header";
import Body from "./Body";
import CreateAuthor from "./CreateAuthor";
import SubmitBtn from "./Fields/SubmitBtn";
import UpdateAuthor from "./UpdateAuthor";
import Bio from "./Fields/Bio";
import Birthdate from "./Fields/Birthdate";
import PhotoPreview from "./Fields/PhotoPreview";
import PhotoUpload from "./Fields/PhotoUpload";
import Name from "./Fields/Name";

const AuthorForm = ({ defaults, children }) => {
    const { data, setData, post, errors, processing, clearErrors } = useForm(
        defaults
    );

    const previewFile = useUploadPreview(
        data.photo && data.photo.name ? data.photo : null
    );

    const changeFieldValue = (field, value) => {
        clearErrors(field);
        setData(field, value);
    };

    return (
        <AuthorFormContext.Provider
            value={{
                data,
                errors,
                changeFieldValue,
                previewFile,
                processing,
                post,
            }}
        >
            <div>{children}</div>
        </AuthorFormContext.Provider>
    );
};

AuthorForm.propTypes = {
    children: PropTypes.node,
    defaults: AuthorType,
};

AuthorForm.defaultProps = {
    children: undefined,
    defaults: {},
};

AuthorForm.Body = Body;
AuthorForm.CreateAuthor = CreateAuthor;
AuthorForm.UpdateAuthor = UpdateAuthor;
AuthorForm.Header = Header;
AuthorForm.Name = Name;
AuthorForm.Bio = Bio;
AuthorForm.Birthdate = Birthdate;
AuthorForm.PhotoPreview = PhotoPreview;
AuthorForm.PhotoUpload = PhotoUpload;
AuthorForm.SubmitBtn = SubmitBtn;

export default AuthorForm;
