import PropTypes from "prop-types";
import React from "react";

const ImagePreview = ({ children, imageUrl, width = 200, height = 300 }) => (
    <div className="space-y-2">
        <div className="text-gray-600">
            <div>{children}</div>
        </div>
        <img
            src={imageUrl}
            alt="Book cover"
            className="shadow-md object-cover"
            style={{ height: `${height}px`, width: `${width}px` }}
        />
    </div>
);

ImagePreview.propTypes = {
    children: PropTypes.node,
    imageUrl: PropTypes.string.isRequired,
    width: PropTypes.number,
    height: PropTypes.number,
};

ImagePreview.defaultProps = {
    children: undefined,
    width: 200,
    height: 300,
};

export default ImagePreview;
