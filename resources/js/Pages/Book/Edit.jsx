import React from "react";
import { arrayOf } from "prop-types";
import Main from "../../Layouts/Main";
import AuthorType from "../../Types/AuthorType";
import BookType from "../../Types/BookType";
import BookForm from "../../Components/BookForm/BookForm";

const Edit = ({ book, authors }) => (
    <Main>
        <div className="md:w-1/3 mb-2">
            <BookForm
                authors={authors}
                defaults={{
                    title: book.title,
                    author_id: book.author_id,
                    cover: null,
                    subtitle: book.subtitle,
                    description: book.description,
                    preview: book.preview,
                    _method: "PUT",
                }}
            >
                <BookForm.UpdateBook book={book}>
                    <BookForm.Header />
                    <BookForm.Body>
                        <BookForm.Title />
                        <BookForm.Author />
                        <BookForm.CoverPreview />
                        <BookForm.CoverUpload />
                        <BookForm.Subtitle />
                        <BookForm.Preview />
                        <BookForm.Description />
                        <BookForm.SubmitBtn>Update</BookForm.SubmitBtn>
                    </BookForm.Body>
                </BookForm.UpdateBook>
            </BookForm>
        </div>
    </Main>
);

Edit.propTypes = {
    book: BookType.isRequired,
    authors: arrayOf(AuthorType),
};

Edit.defaultProps = {
    authors: [],
};

export default Edit;
