import React, { useContext } from "react";
import BookFormContext from "../../../Context/BookFormContext";

const CoverPreview = () => {
    const { PreviewComponent } = useContext(BookFormContext);

    return <PreviewComponent />;
};

export default CoverPreview;
