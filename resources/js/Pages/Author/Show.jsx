import React from "react";
import AuthorType from "../../Types/AuthorType";
import Main from "../../Layouts/Main";
import BookList from "../../Components/BookList";

const Show = ({ author }) => (
    <Main>
        <div className="space-y-4 m">
            <h1 className="text-3xl">{author.name}</h1>
            <div className="space-y-2 md:space-y-0 md:space-x-4 md:flex">
                <div>
                    <img src={author.photo} alt="Author" className="w-96" />
                </div>
                <div className="space-y-2 flex-grow">
                    <div>Born: {author.birthdate}</div>
                    <div>{author.bio}</div>
                </div>
            </div>
            <BookList books={author.books} />
        </div>
    </Main>
);

Show.propTypes = {
    author: AuthorType,
};

Show.defaultProps = {
    author: {},
};

export default Show;
