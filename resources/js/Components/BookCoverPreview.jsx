import React from "react";
import PropTypes from "prop-types";
import ImagePreview from "./ImagePreview";
import { BOOK_COVER_H, BOOK_COVER_W } from "../Constants/general";

const BookCoverPreview = ({ imageUrl, children }) => (
    <ImagePreview
        imageUrl={imageUrl}
        width={BOOK_COVER_W}
        height={BOOK_COVER_H}
    >
        {children}
    </ImagePreview>
);

BookCoverPreview.propTypes = {
    children: PropTypes.node,
    imageUrl: PropTypes.string.isRequired,
};

BookCoverPreview.defaultProps = {
    children: undefined,
};

export default BookCoverPreview;
