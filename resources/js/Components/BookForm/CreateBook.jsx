import React, { useContext } from "react";
import PropTypes from "prop-types";
import BookFormContext from "../../Context/BookFormContext";
import BookCoverPreview from "../BookCoverPreview";
import ResizeNotice from "../ResizeNotice";
import { BOOK_COVER_H, BOOK_COVER_W } from "../../Constants/general";

const CreateBook = ({ children }) => {
    const bookFormContext = useContext(BookFormContext);
    const { post, previewFile } = bookFormContext;

    const submit = (e) => {
        e.preventDefault();
        post(route("books.store"), {
            forceFormData: true,
        });
    };

    const PreviewComponent = () => (
        <div className="ml-2">
            {previewFile && (
                <BookCoverPreview imageUrl={previewFile}>
                    <div>Cover preview</div>
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

CreateBook.propTypes = {
    children: PropTypes.node,
};

CreateBook.defaultProps = {
    children: undefined,
};

export default CreateBook;
