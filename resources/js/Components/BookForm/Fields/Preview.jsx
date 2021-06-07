import React, { useContext } from "react";
import BookFormContext from "../../../Context/BookFormContext";
import Text from "../../Form/Text";

const Preview = () => {
    const { data, changeFieldValue, errors } = useContext(BookFormContext);

    return (
        <div>
            <Text
                onChange={(value) => changeFieldValue("preview", value)}
                value={data.preview}
                label="Preview"
                error={errors.preview}
                rows="7"
            />
        </div>
    );
};

export default Preview;
