import React from "react";
import PropTypes from "prop-types";

const Index = ({ books }) => (
    <div>
        {books.map((book) => (
            <div key={book.id}>{book.title}</div>
        ))}
    </div>
);

Index.propTypes = {
    books: PropTypes.arrayOf(Object),
};

Index.defaultProps = {
    books: [],
};

export default Index;
