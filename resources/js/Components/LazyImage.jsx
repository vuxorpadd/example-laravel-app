import React from "react";
import { LazyLoadImage } from "react-lazy-load-image-component";
import "react-lazy-load-image-component/src/effects/blur.css";

const LazyImage = ({ ...rest }) => <LazyLoadImage effect="blur" {...rest} />;

export default LazyImage;
