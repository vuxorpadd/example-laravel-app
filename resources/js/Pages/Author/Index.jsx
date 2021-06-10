import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import PropTypes from "prop-types";
import Main from "../../Layouts/Main";
import AuthorListCard from "../../Components/AuthorListCard";
import useScrollPagination from "../../Hooks/useScrollPagination";
import PaginatorType from "../../Types/PaginatorType";

const Index = ({ paginator, permissions }) => {
    const { LoadMoreButton, data } = useScrollPagination(paginator);

    return (
        <Main>
            <h2 className="mb-4 text-3xl text-gray-600">Authors</h2>
            <div className="space-y-4">
                {permissions.create && (
                    <div>
                        <InertiaLink
                            className="btn btn-primary"
                            href={route("authors.create")}
                        >
                            Add
                        </InertiaLink>
                    </div>
                )}
                <div className="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    {data.map((author) => (
                        <AuthorListCard key={author.id} author={author} />
                    ))}
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
