import React, { useContext } from "react";
import PropTypes from "prop-types";
import BookCoverPreview from "../BookCoverPreview";
import ResizeNotice from "../ResizeNotice";
import { BOOK_COVER_H, BOOK_COVER_W } from "../../Constants/general";
import BookType from "../../Types/BookType";
import BookFormContext from "../../Context/BookFormContext";

const UpdateBook = ({ book, children }) => {
    const bookFormContext = useContext(BookFormContext);
    const { post, previewFile } = bookFormContext;

    const submit = (e) => {
        e.preventDefault();
        post(route("books.update", { book }), {
            forceFormData: true,
        });
    };

    const PreviewComponent = () => (
        <div className="ml-2">
            {!previewFile ? (
                <BookCoverPreview imageUrl={book.cover_url}>
                    Current cover:
                </BookCoverPreview>
            ) : (
                <BookCoverPreview imageUrl={previewFile}>
                    <div>New cover preview </div>
                    <ResizeNotice height={BOOK_COVER_H} width={BOOK_COVER_W} />
                </BookCoverPreview>
            )}
        </div>
    );

    return (
        <BookFormContext.Provider
            value={{ ...bookFormContext, submit, PreviewComponent }}
        >
            {children}
        </BookFormContext.Provider>
    );
};

UpdateBook.propTypes = {
    book: BookType.isRequired,
    children: PropTypes.node,
};

UpdateBook.defaultProps = {
    children: undefined,
};

export default UpdateBook;
