import React from "react";
import { arrayOf } from "prop-types";
import Main from "../../Layouts/Main";
import AuthorType from "../../Types/AuthorType";
import BookForm from "../../Components/BookForm/BookForm";

const Create = ({ authors }) => (
    <Main>
        <div className="md:w-1/3 mb-2">
            <BookForm
                authors={authors}
                defaults={{
                    title: "",
                    author_id: authors[0].id.toString() ?? "",
                    cover: "",
                    subtitle: "",
                    description: "",
                    preview: "",
                }}
            >
                <BookForm.CreateBook>
                    <BookForm.Header>New book</BookForm.Header>
                    <BookForm.Body>
                        <BookForm.Title />
                        <BookForm.Author />
                        <BookForm.CoverPreview />
                        <BookForm.CoverUpload />
                        <BookForm.Subtitle />
                        <BookForm.Preview />
                        <BookForm.Description />
                        <BookForm.SubmitBtn>Add</BookForm.SubmitBtn>
                    </BookForm.Body>
                </BookForm.CreateBook>
            </BookForm>
        </div>
    </Main>
);

Create.propTypes = {
    authors: arrayOf(AuthorType),
};

Create.defaultProps = {
    authors: [],
};

export default Create;
