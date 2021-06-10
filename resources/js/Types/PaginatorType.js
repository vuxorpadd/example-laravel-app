import { arrayOf, shape, string } from "prop-types";
import BookType from "./BookType";
import AuthorType from "./AuthorType";

export default shape({
    data: arrayOf(BookType || AuthorType),
    next_page_url: string,
});
