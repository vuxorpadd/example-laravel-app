import React from "react";
import PropTypes from "prop-types";
import { InertiaLink } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import BookList from "../../Components/BookList";
import useScrollPagination from "../../Hooks/useScrollPagination";
import PaginatorType from "../../Types/PaginatorType";

const Index = ({ paginator, permissions }) => {
    const { LoadMoreButton, data } = useScrollPagination(paginator);

    return (
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
                    <BookList books={data} />
                </div>
                <div className="py-4">
                    <LoadMoreButton />
                </div>
            </div>
        </Main>
    );
};

Index.propTypes = {
    paginator: PaginatorType.isRequired,
    permissions: PropTypes.objectOf(() => PropTypes.boolean).isRequired,
};

export default Index;
