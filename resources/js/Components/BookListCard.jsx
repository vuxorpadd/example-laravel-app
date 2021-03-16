import React from "react";
import PropTypes, { number, string } from "prop-types";
import { Inertia } from "@inertiajs/inertia";

const BookListCard = ({ book }) => (
    <button
        type="button"
        onClick={() => Inertia.get(route("books.show", { book }))}
        className="bg-green-50 p-2 m-2 rounded-md shadow-sm inline-block"
    >
        {book.title}
    </button>
);

BookListCard.propTypes = {
    book: PropTypes.shape({
        id: number,
        title: string,
    }).isRequired,
};

export default BookListCard;
