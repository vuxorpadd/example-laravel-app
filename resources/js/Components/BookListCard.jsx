import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import BookType from "../Types/BookType";
import WishlistButton from "./WishlistButton";

const BookListCard = ({ book }) => (
    <div className="inline-flex p-2 bg-gray-50 rounded-md shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gray-200">
        <div className="flex md:space-y-4 md:block gap-4">
            <InertiaLink href={route("books.show", { book })}>
                <img
                    src={book.cover_url}
                    alt="Book cover"
                    className="w-32 md:mx-auto md:w-full"
                />
            </InertiaLink>
            <div className="flex-grow text-left md:space-y-2">
                <div className="flex gap-2">
                    <div className="flex-grow">
                        <div className="text-xl">
                            <InertiaLink href={route("books.show", { book })}>
                                {book.title}
                            </InertiaLink>
                        </div>
                        <div className="italic">by {book.author.name}</div>
                    </div>
                    <div className="flex-grow-0 w-8">
                        <WishlistButton book={book} />
                    </div>
                </div>
                <div>{book.subtitle}</div>
                <div>
                    <p>
                        {book.description && book.description.length > 50
                            ? `${book.description.slice(0, 50)}...`
                            : book.description}
                    </p>
                </div>
            </div>
        </div>
    </div>
);

BookListCard.propTypes = {
    book: BookType.isRequired,
};

export default BookListCard;
