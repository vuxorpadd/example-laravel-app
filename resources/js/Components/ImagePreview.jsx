import PropTypes from "prop-types";
import React from "react";

const ImagePreview = ({ children, imageUrl }) => (
    <div className="space-y-2">
        <div className="text-gray-600">
            <div>{children}</div>
        </div>
        <img
            src={imageUrl}
            alt="Book cover"
            className="shadow-md object-cover w-32 h-52"
        />
    </div>
);

ImagePreview.propTypes = {
    children: PropTypes.node,
    imageUrl: PropTypes.string.isRequired,
};

ImagePreview.defaultProps = {
    children: undefined,
};

export default ImagePreview;
