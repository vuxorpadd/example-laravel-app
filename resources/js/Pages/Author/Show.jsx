import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import AuthorType from "../../Types/AuthorType";
import Main from "../../Layouts/Main";
import BookList from "../../Components/BookList";
import AdminOnly from "../../Components/AdminOnly";

const Show = ({ author }) => {
    const deleteAuthor = () => {
        Inertia.delete(route("authors.destroy", { author }));
    };

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
                    <div className="space-y-2 flex flex-col-reverse md:flex-row">
                        <div className="space-y-2">
                            <div>Born: {author.birthdate}</div>
                            <div>{author.bio}</div>
                        </div>
                        <AdminOnly>
                            <div className="md:flex-none md:w-40 text-center space-y-2">
                                <div>
                                    <InertiaLink
                                        className="btn btn-primary"
                                        href={route("authors.edit", { author })}
                                    >
                                        Edit
                                    </InertiaLink>
                                </div>
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
                            </div>
                        </AdminOnly>
                    </div>
                </div>
                <BookList books={author.books} />
            </div>
        </Main>
    );
};

Show.propTypes = {
    author: AuthorType,
};

Show.defaultProps = {
    author: {},
};

export default Show;
