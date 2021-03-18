import React from "react";
import Main from "../../Layouts/Main";
import BookType from "../../Types/BookType";

const Show = ({ book }) => (
    <Main>
        <div className="space-y-4 m">
            <h1 className="text-3xl">{book.title}</h1>
            <div>
                <img src={book.cover} alt="Book cover" className="shadow-md" />
            </div>
            <h2 className="text-xl">{book.subtitle}</h2>
            <div>
                <div className="text-lg">Description:</div>
                <p>{book.description}</p>
            </div>
            <div>
                <div className="text-lg">Preview:</div>
                <p className="text-gray-800 italic">{book.preview}...</p>
            </div>
        </div>
    </Main>
);

Show.propTypes = {
    book: BookType,
};

Show.defaultProps = {
    book: {},
};

export default Show;
