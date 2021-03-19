import React from "react";
import PropTypes from "prop-types";
import AuthorType from "../../Types/AuthorType";
import Main from "../../Layouts/Main";
import AuthorListCard from "../../Components/AuthorListCard";

const Index = ({ authors }) => (
    <Main>
        <div className="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            {authors.map((author) => (
                <AuthorListCard key={author.id} author={author} />
            ))}
        </div>
    </Main>
);

Index.propTypes = {
    authors: PropTypes.arrayOf(AuthorType),
};

Index.defaultProps = {
    authors: [],
};

export default Index;
