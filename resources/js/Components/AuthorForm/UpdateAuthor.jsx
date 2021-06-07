import React, { useContext } from "react";
import PropTypes from "prop-types";
import ResizeNotice from "../ResizeNotice";
import { AUTHOR_PHOTO_H, AUTHOR_PHOTO_W } from "../../Constants/general";
import AuthorType from "../../Types/AuthorType";
import AuthorFormContext from "../../Context/AuthorFormContext";
import AuthorPhotoPreview from "../AuthorPhotoPreview";

const UpdateAuthor = ({ author, children }) => {
    const authorFormContext = useContext(AuthorFormContext);
    const { post, previewFile } = authorFormContext;

    const submit = (e) => {
        e.preventDefault();
        post(route("authors.update", { author }), {
            forceFormData: true,
        });
    };

    const PreviewComponent = () => (
        <div className="ml-2">
            {!previewFile ? (
                <AuthorPhotoPreview imageUrl={author.photo_url}>
                    Current cover:
                </AuthorPhotoPreview>
            ) : (
                <AuthorPhotoPreview imageUrl={previewFile}>
                    <div>New photo preview </div>
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

UpdateAuthor.propTypes = {
    author: AuthorType.isRequired,
    children: PropTypes.node,
};

UpdateAuthor.defaultProps = {
    children: undefined,
};

export default UpdateAuthor;
