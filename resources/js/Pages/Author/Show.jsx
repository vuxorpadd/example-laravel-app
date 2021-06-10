import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import PropTypes from "prop-types";
import AuthorType from "../../Types/AuthorType";
import Main from "../../Layouts/Main";
import BookList from "../../Components/BookList";
import PaginatorType from "../../Types/PaginatorType";
import useScrollPagination from "../../Hooks/useScrollPagination";

const Show = ({ author, booksPaginator, permissions }) => {
    const deleteAuthor = () => {
        Inertia.delete(route("authors.destroy", { author }));
    };

    const { LoadMoreButton, data: books } = useScrollPagination(
        booksPaginator,
        "booksPaginator"
    );

    return (
        <Main>
            <div className="space-y-4">
                <h1 className="text-3xl text-center md:text-left">
                    {author.name}
                </h1>
                <div className="space-y-2 md:space-y-0 md:space-x-4 md:flex">
                    <div className="flex-none w-96">
                        <img
                            src={author.photo_url}
                            alt="Author"
                            className="w-96 inline"
                        />
                    </div>
                    <div className="space-y-2 flex flex-col-reverse md:flex-row md:flex-grow">
                        <div className="space-y-2 md:flex-grow">
                            <div>Born: {author.birthdate}</div>
                            <div>{author.bio}</div>
                        </div>
                        <div className="md:flex-none md:w-40 text-center space-y-2 md:border-l-2 md:pl-2 md:ml-2">
                            {permissions.update && (
                                <div>
                                    <InertiaLink
                                        className="btn btn-primary"
                                        href={route("authors.edit", {
                                            author,
                                        })}
                                    >
                                        Edit
                                    </InertiaLink>
                                </div>
                            )}
                            {permissions.delete && (
                                <div>
                                    <button
                                        type="button"
                                        className="mb-4 underline"
                                        onClick={(e) => {
                                            e.preventDefault();
                                            deleteAuthor();
                                        }}
                                    >
                                        Delete
                                    </button>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
                <div>
                    {books.length > 0 ? (
                        <>
                            <h2 className="mb-4 text-xl text-gray-600">
                                {`${author.name}'s books`}
                            </h2>
                            <BookList books={books} />
                        </>
                    ) : (
                        <span>
                            {`${author.name} hasn't written any books yet`}
                        </span>
                    )}
                </div>
                <div className="py-4">
                    <LoadMoreButton />
                </div>
            </div>
        </Main>
    );
};

Show.propTypes = {
    author: AuthorType,
    booksPaginator: PaginatorType.isRequired,
    permissions: PropTypes.objectOf(() => PropTypes.boolean).isRequired,
};

Show.defaultProps = {
    author: {},
};

export default Show;
