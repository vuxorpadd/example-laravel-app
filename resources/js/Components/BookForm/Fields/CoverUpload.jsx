import React, { useContext } from "react";
import BookFormContext from "../../../Context/BookFormContext";
import FileUpload from "../../Form/FileUpload";

const CoverUpload = () => {
    const { changeFieldValue, errors, data } = useContext(BookFormContext);

    return (
        <div>
            <FileUpload
                label="Cover image"
                accept="image/png, image/jpeg"
                onChange={(value) => {
                    changeFieldValue("cover", value);
                }}
                error={errors.cover}
                filename={data.cover && data.cover.name ? data.cover.name : ""}
            />
        </div>
    );
};

export default CoverUpload;
