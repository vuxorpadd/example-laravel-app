import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import PropTypes from "prop-types";
import Main from "../../Layouts/Main";
import BookType from "../../Types/BookType";
import WishlistButton from "../../Components/WishlistButton";

const Show = ({ book, permissions }) => {
    const deleteBook = () => {
        Inertia.delete(route("books.destroy", { book }));
    };

    return (
        <Main>
            <div className="md:flex space-y-4">
                <div className="space-y-4 md:flex-none md:w-52 md:mr-6 text-center">
                    <div>
                        <h1 className="text-3xl">{book.title}</h1>
                        <div className="italic">
                            by{" "}
                            <InertiaLink
                                className="text-gray-500 underline"
                                href={route("authors.show", {
                                    author: book.author,
                                })}
                            >
                                {book.author.name}
                            </InertiaLink>
                        </div>
                    </div>
                    <div className="text-center">
                        <img
                            src={book.cover_url}
                            alt="Book cover"
                            className="shadow-md inline-block"
                        />
                    </div>
                    <h2 className="text-xl">{book.subtitle}</h2>
                    <div className="border-b-2 pb-4 md:pb-0 md:border-b-0 border-gray-50">
                        <WishlistButton book={book} />
                    </div>
                </div>
                <div className="flex flex-col-reverse md:flex-row md:flex-grow">
                    <div className="space-y-4 md:border-r-2 md:border-l-2 md:px-4 md:flex-grow">
                        <div>
                            <div className="text-lg">Description:</div>
                            <p>{book.description}</p>
                        </div>
                        <div>
                            <div className="text-lg">Preview:</div>
                            <p className="text-gray-800 italic">
                                {book.preview}...
                            </p>
                        </div>
                    </div>
                    <div className="md:flex-none md:ml-6">
                        {permissions.update && (
                            <div className="text-center">
                                <InertiaLink
                                    className="btn btn-primary mb-4"
                                    href={route("books.edit", { book })}
                                >
                                    Edit
                                </InertiaLink>
                            </div>
                        )}
                        {permissions.delete && (
                            <div className="text-center">
                                <button
                                    type="button"
                                    className="mb-4 underline"
                                    onClick={(e) => {
                                        e.preventDefault();
                                        deleteBook();
                                    }}
                                >
                                    Delete
                                </button>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </Main>
    );
};

Show.propTypes = {
    book: BookType,
    permissions: PropTypes.objectOf(() => PropTypes.boolean).isRequired,
};

Show.defaultProps = {
    book: {},
};

export default Show;
