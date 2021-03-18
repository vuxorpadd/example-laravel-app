import React from "react";
import { Inertia } from "@inertiajs/inertia";
import BookType from "../Types/BookType";

const BookListCard = ({ book }) => (
    <button
        type="button"
        onClick={() => Inertia.get(route("books.show", { book }))}
        className="bg-gray-50 p-2 m-2 rounded-md shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gray-200"
    >
        <div className="md:space-y-4 flex md:block">
            <div className="flex mr-4">
                <img
                    src={book.cover}
                    alt="Book cover"
                    className="md:mx-auto w-32 md:w-full"
                />
            </div>
            <div className="text-left md:space-y-2 flex-grow">
                <div className="text-xl">{book.title}</div>
                <div>{book.subtitle}</div>
                <div>
                    <p>
                        {book.description.length > 50
                            ? `${book.description.slice(0, 50)}...`
                            : book.description}
                    </p>
                </div>
            </div>
        </div>
    </button>
);

BookListCard.propTypes = {
    book: BookType.isRequired,
};

export default BookListCard;
