import React, { useContext } from "react";
import AuthorFormContext from "../../../Context/AuthorFormContext";
import FileUpload from "../../Form/FileUpload";

const PhotoUpload = () => {
    const { changeFieldValue, errors, data } = useContext(AuthorFormContext);

    return (
        <div>
            <FileUpload
                label="Photo"
                accept="image/png, image/jpeg"
                onChange={(value) => {
                    changeFieldValue("photo", value);
                }}
                error={errors.photo}
                filename={data.photo && data.photo.name ? data.photo.name : ""}
            />
        </div>
    );
};

export default PhotoUpload;
