import React, { useContext } from "react";
import BookFormContext from "../../../Context/BookFormContext";
import Input from "../../Form/Input";

const Title = () => {
    const { data, changeFieldValue, errors } = useContext(BookFormContext);

    return (
        <div>
            <Input
                onChange={(value) => changeFieldValue("title", value)}
                value={data.title}
                label="Title"
                error={errors.title}
            />
        </div>
    );
};

export default Title;
