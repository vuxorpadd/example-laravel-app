import React, { useContext } from "react";
import BookFormContext from "../../../Context/BookFormContext";
import Text from "../../Form/Text";

const Subtitle = () => {
    const { data, changeFieldValue, errors } = useContext(BookFormContext);

    return (
        <div>
            <Text
                onChange={(value) => changeFieldValue("subtitle", value)}
                value={data.subtitle}
                label="Subtitle"
                error={errors.subtitle}
                cols="30"
            />
        </div>
    );
};

export default Subtitle;
