import React, { useContext } from "react";
import AuthorFormContext from "../../../Context/AuthorFormContext";
import Input from "../../Form/Input";

const Name = () => {
    const { data, changeFieldValue, errors } = useContext(AuthorFormContext);

    return (
        <div>
            <Input
                onChange={(value) => changeFieldValue("name", value)}
                value={data.name}
                label="Name"
                error={errors.name}
            />
        </div>
    );
};

export default Name;
