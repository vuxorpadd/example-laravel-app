import React, { useContext } from "react";
import AuthorFormContext from "../../../Context/AuthorFormContext";
import Text from "../../Form/Text";

const Bio = () => {
    const { data, changeFieldValue, errors } = useContext(AuthorFormContext);

    return (
        <div>
            <Text
                onChange={(value) => changeFieldValue("bio", value)}
                value={data.bio}
                label="Bio"
                error={errors.bio}
                rows="15"
            />
        </div>
    );
};

export default Bio;
