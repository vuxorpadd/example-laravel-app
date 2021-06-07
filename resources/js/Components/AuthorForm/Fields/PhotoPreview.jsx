import React, { useContext } from "react";
import AuthorFormContext from "../../../Context/AuthorFormContext";

const PhotoPreview = () => {
    const { PreviewComponent } = useContext(AuthorFormContext);

    return <PreviewComponent />;
};

export default PhotoPreview;
