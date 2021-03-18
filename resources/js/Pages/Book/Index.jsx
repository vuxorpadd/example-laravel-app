import React from "react";
import PropTypes from "prop-types";
import Main from "../../Layouts/Main";
import BookList from "../../Components/BookList";
import BookType from "../../Types/BookType";

const Index = ({ books }) => (
    <Main>
        <BookList books={books} />
    </Main>
);

Index.propTypes = {
    books: PropTypes.arrayOf(BookType),
};

Index.defaultProps = {
    books: [],
};

export default Index;
