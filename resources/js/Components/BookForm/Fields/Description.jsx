import React, { useContext } from "react";
import BookFormContext from "../../../Context/BookFormContext";
import Text from "../../Form/Text";

const Description = () => {
    const { data, changeFieldValue, errors } = useContext(BookFormContext);

    return (
        <div>
            <Text
                onChange={(value) => changeFieldValue("description", value)}
                value={data.description}
                label="Description"
                error={errors.description}
                rows="15"
            />
        </div>
    );
};

export default Description;
