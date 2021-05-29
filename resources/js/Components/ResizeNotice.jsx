import React from "react";
import PropTypes from "prop-types";

const ResizeNotice = ({ width = 200, height = 300 }) => (
    <div className="text-gray-300">
        we will resize it to fit {width}x{height} ratio
    </div>
);

ResizeNotice.propTypes = {
    width: PropTypes.number.isRequired,
    height: PropTypes.number.isRequired,
};

export default ResizeNotice;
