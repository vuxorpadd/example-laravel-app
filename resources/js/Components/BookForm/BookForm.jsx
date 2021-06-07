import React from "react";
import { useForm } from "@inertiajs/inertia-react";
import PropTypes, { arrayOf } from "prop-types";
import BookFormContext from "../../Context/BookFormContext";
import useUploadPreview from "../../Hooks/useUploadPreview";
import AuthorType from "../../Types/AuthorType";
import BookType from "../../Types/BookType";
import Header from "./Header";
import Author from "./Fields/Author";
import Body from "./Body";
import CoverPreview from "./Fields/CoverPreview";
import CoverUpload from "./Fields/CoverUpload";
import CreateBook from "./CreateBook";
import Description from "./Fields/Description";
import Preview from "./Fields/Preview";
import SubmitBtn from "./Fields/SubmitBtn";
import Subtitle from "./Fields/Subtitle";
import Title from "./Fields/Title";
import UpdateBook from "./UpdateBook";

const BookForm = ({ authors, defaults, children }) => {
    const { data, setData, post, errors, processing, clearErrors } = useForm(
        defaults
    );

    const previewFile = useUploadPreview(
        data.cover && data.cover.name ? data.cover : null
    );

    const changeFieldValue = (field, value) => {
        clearErrors(field);
        setData(field, value);
    };

    return (
        <BookFormContext.Provider
            value={{
                data,
                errors,
                changeFieldValue,
                previewFile,
                processing,
                post,
                authors,
            }}
        >
            <div>{children}</div>
        </BookFormContext.Provider>
    );
};

BookForm.propTypes = {
    children: PropTypes.node,
    authors: arrayOf(AuthorType),
    defaults: BookType,
};

BookForm.defaultProps = {
    authors: [],
    children: undefined,
    defaults: {},
};

BookForm.Author = Author;
BookForm.Body = Body;
BookForm.CoverPreview = CoverPreview;
BookForm.CoverUpload = CoverUpload;
BookForm.CreateBook = CreateBook;
BookForm.Description = Description;
BookForm.Header = Header;
BookForm.Preview = Preview;
BookForm.SubmitBtn = SubmitBtn;
BookForm.Subtitle = Subtitle;
BookForm.Title = Title;
BookForm.UpdateBook = UpdateBook;

export default BookForm;
