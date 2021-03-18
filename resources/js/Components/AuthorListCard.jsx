import React from "react";
import { Inertia } from "@inertiajs/inertia";
import AuthorType from "../Types/AuthorType";

const AuthorListCard = ({ author }) => (
    <button
        type="button"
        onClick={() => Inertia.get(route("authors.show", { author }))}
        className="bg-gray-50 p-2 m-2 rounded-md shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gray-200"
    >
        <div className="space-y-4 block">
            <div className="align-middle">
                <img
                    src={author.photo}
                    alt="Author"
                    className="w-96 inline-flex"
                />
            </div>
            <div>{author.name}</div>
        </div>
    </button>
);

AuthorListCard.propTypes = {
    author: AuthorType.isRequired,
};

export default AuthorListCard;
