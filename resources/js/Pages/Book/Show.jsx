import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import BookType from "../../Types/BookType";

const Show = ({ book }) => (
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
            </div>
            <div className="flex flex-col-reverse md:flex-row">
                <div className="space-y-4 md:border-r-2 md:border-l-2 md:px-4">
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
                    <InertiaLink
                        className="btn btn-primary mb-4"
                        href={route("books.edit", { book })}
                    >
                        Edit
                    </InertiaLink>
                </div>
            </div>
        </div>
    </Main>
);

Show.propTypes = {
    book: BookType,
};

Show.defaultProps = {
    book: {},
};

export default Show;
