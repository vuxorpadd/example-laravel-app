import React, { useContext } from "react";
import AuthorFormContext from "../../../Context/AuthorFormContext";
import DateInput from "../../Form/DateInput";

const Birthdate = () => {
    const { data, changeFieldValue, errors } = useContext(AuthorFormContext);

    return (
        <div>
            <DateInput
                onChange={(value) => changeFieldValue("birthdate", value)}
                value={data.birthdate}
                error={errors.birthdate}
                label="Birthdate"
            />
        </div>
    );
};

export default Birthdate;
