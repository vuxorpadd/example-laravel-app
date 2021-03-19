import React from "react";
import PropTypes from "prop-types";
import BookType from "../Types/BookType";
import BookListCard from "./BookListCard";

const BookList = ({ books }) => (
    <div className="grid grid-cols-1 gap-4 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
        {books.map((book) => (
            <BookListCard key={book.id} book={book} />
        ))}
    </div>
);

BookList.propTypes = {
    books: PropTypes.arrayOf(BookType),
};

BookList.defaultProps = {
    books: [],
};

export default BookList;
