import React from "react";
import PropTypes from "prop-types";
import { InertiaLink } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import BookList from "../../Components/BookList";
import BookType from "../../Types/BookType";

const Index = ({ books, permissions }) => (
    <Main>
        <h2 className="mb-4 text-3xl text-gray-600">Books</h2>
        <div className="space-y-4">
            {permissions.create && (
                <div>
                    <InertiaLink
                        className="btn btn-primary"
                        href={route("books.create")}
                    >
                        Add
                    </InertiaLink>
                </div>
            )}
            <div>
                <BookList books={books} />
            </div>
        </div>
    </Main>
);

Index.propTypes = {
    books: PropTypes.arrayOf(BookType),
    permissions: PropTypes.objectOf(() => PropTypes.boolean).isRequired,
};

Index.defaultProps = {
    books: [],
};

export default Index;
