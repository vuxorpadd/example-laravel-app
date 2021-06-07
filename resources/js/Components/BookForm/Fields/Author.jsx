import React, { useContext } from "react";
import Select from "../../Form/Select";
import BookFormContext from "../../../Context/BookFormContext";

const Author = () => {
    const { data, errors, authors, changeFieldValue } = useContext(
        BookFormContext
    );

    return (
        <div>
            <Select
                value={data.author_id}
                onChange={(value) => changeFieldValue("author_id", value)}
                error={errors.author_id}
                options={authors.map(({ id, name }) => ({
                    value: id,
                    label: name,
                }))}
            />
        </div>
    );
};

export default Author;
