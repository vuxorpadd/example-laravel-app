import React, { useContext } from "react";
import PropTypes from "prop-types";
import AuthorFormContext from "../../Context/AuthorFormContext";
import ResizeNotice from "../ResizeNotice";
import { AUTHOR_PHOTO_H, AUTHOR_PHOTO_W } from "../../Constants/general";
import AuthorPhotoPreview from "../AuthorPhotoPreview";

const CreateAuthor = ({ children }) => {
    const authorFormContext = useContext(AuthorFormContext);
    const { post, previewFile } = authorFormContext;

    const submit = (e) => {
        e.preventDefault();
        post(route("authors.store"), {
            forceFormData: true,
        });
    };

    const PreviewComponent = () => (
        <div className="ml-2">
            {previewFile && (
                <AuthorPhotoPreview imageUrl={previewFile}>
                    <div>Photo preview</div>
                    <ResizeNotice
                        height={AUTHOR_PHOTO_H}
                        width={AUTHOR_PHOTO_W}
                    />
                </AuthorPhotoPreview>
            )}
        </div>
    );

    return (
        <AuthorFormContext.Provider
            value={{ ...authorFormContext, submit, PreviewComponent }}
        >
            {children}
        </AuthorFormContext.Provider>
    );
};

CreateAuthor.propTypes = {
    children: PropTypes.node,
};

CreateAuthor.defaultProps = {
    children: undefined,
};

export default CreateAuthor;
