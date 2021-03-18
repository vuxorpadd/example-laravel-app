import React from "react";
import PropTypes from "prop-types";
import Main from "../../Layouts/Main";
import BookListCard from "../../Components/BookListCard";

const Index = ({ books }) => (
    <Main>
        <div className="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4">
            {books.map((book) => (
                <BookListCard key={book.id} book={book} />
            ))}
        </div>
    </Main>
);

Index.propTypes = {
    books: PropTypes.arrayOf(Object),
};

Index.defaultProps = {
    books: [],
};

export default Index;
