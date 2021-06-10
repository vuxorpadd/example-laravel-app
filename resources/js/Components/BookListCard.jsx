import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import BookType from "../Types/BookType";
import WishlistButton from "./WishlistButton";
import useWishlist from "../Hooks/useWishlist";
import LazyImage from "./LazyImage";

const BookListCard = ({ book }) => {
    const wishlist = useWishlist();

    return (
        <div className="p-2 bg-gray-50 rounded-md shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gray-200">
            <div className="flex md:block gap-4">
                <div className="w-32 md:w-full flex-none">
                    <InertiaLink
                        href={route("books.show", { book })}
                        className="flex"
                    >
                        <span className="mx-auto h-52 md:h-80">
                            <LazyImage
                                alt="Book cover"
                                src={book.cover_url}
                                width="200"
                                height="300"
                            />
                        </span>
                    </InertiaLink>
                </div>
                <div className="flex-grow text-left md:space-y-2">
                    <div className="flex gap-2">
                        <div className="flex-grow">
                            <div className="text-xl">
                                <InertiaLink
                                    href={route("books.show", { book })}
                                >
                                    {book.title}
                                </InertiaLink>
                            </div>
                            <div className="italic">by {book.author.name}</div>
                        </div>
                        {wishlist && (
                            <div className="flex-grow-0 w-8">
                                <WishlistButton book={book} />
                            </div>
                        )}
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
};

BookListCard.propTypes = {
    book: BookType.isRequired,
};

export default BookListCard;
