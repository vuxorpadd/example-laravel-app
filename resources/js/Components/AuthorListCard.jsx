import React from "react";
import { Inertia } from "@inertiajs/inertia";
import AuthorType from "../Types/AuthorType";
import LazyImage from "./LazyImage";

const AuthorListCard = ({ author }) => (
    <button
        type="button"
        onClick={() => Inertia.get(route("authors.show", { author }))}
        className="bg-gray-50 rounded-md shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gray-200 p-4"
    >
        <div className="block">
            <div className="h-72 md:h-64">
                <LazyImage
                    alt="Author"
                    src={author.photo_url}
                    className="p-4"
                    width="285"
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
