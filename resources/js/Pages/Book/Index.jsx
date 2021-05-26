import React from "react";
import PropTypes from "prop-types";
import { InertiaLink } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import BookList from "../../Components/BookList";
import BookType from "../../Types/BookType";
import useIsAdmin from "../../Hooks/useIsAdmin";

const Index = ({ books }) => {
    const isAdmin = useIsAdmin();

    return (
        <Main>
            <div className="space-y-4">
                {isAdmin && (
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
};

Index.propTypes = {
    books: PropTypes.arrayOf(BookType),
};

Index.defaultProps = {
    books: [],
};

export default Index;
