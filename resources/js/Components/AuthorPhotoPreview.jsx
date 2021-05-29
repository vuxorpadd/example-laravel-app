import React from "react";
import PropTypes from "prop-types";
import ImagePreview from "./ImagePreview";
import { AUTHOR_PHOTO_H, AUTHOR_PHOTO_W } from "../Constants/general";

const AuthorPhotoPreview = ({ imageUrl, children }) => (
    <ImagePreview
        imageUrl={imageUrl}
        width={AUTHOR_PHOTO_W}
        height={AUTHOR_PHOTO_H}
    >
        {children}
    </ImagePreview>
);

AuthorPhotoPreview.propTypes = {
    children: PropTypes.node,
    imageUrl: PropTypes.string.isRequired,
};

AuthorPhotoPreview.defaultProps = {
    children: undefined,
};

export default AuthorPhotoPreview;
