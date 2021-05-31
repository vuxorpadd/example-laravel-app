import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import PropTypes from "prop-types";
import AuthorType from "../../Types/AuthorType";
import Main from "../../Layouts/Main";
import AuthorListCard from "../../Components/AuthorListCard";

const Index = ({ authors, permissions }) => (
    <Main>
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
                {authors.map((author) => (
                    <AuthorListCard key={author.id} author={author} />
                ))}
            </div>
        </div>
    </Main>
);

Index.propTypes = {
    authors: PropTypes.arrayOf(AuthorType),
    permissions: PropTypes.objectOf(() => PropTypes.boolean).isRequired,
};

Index.defaultProps = {
    authors: [],
};

export default Index;
