import React from "react";
import { Inertia } from "@inertiajs/inertia";
import BookType from "../Types/BookType";

const BookListCard = ({ book }) => (
    <button
        type="button"
        onClick={() => Inertia.get(route("books.show", { book }))}
        className="inline-flex p-2 bg-gray-50 rounded-md shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gray-200"
    >
        <div className="flex md:space-y-4 md:block gap-4">
            <div>
                <img
                    src={book.cover}
                    alt="Book cover"
                    className="w-32 md:mx-auto md:w-full"
                />
            </div>
            <div className="flex-grow text-left md:space-y-2">
                <div>
                    <div className="text-xl">{book.title}</div>
                    <div className="italic">by {book.author.name}</div>
                </div>
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
