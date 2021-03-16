import React from "react";
import PropTypes, { number, string } from "prop-types";

const Show = ({ book }) => <div>{book.title}</div>;

Show.propTypes = {
    book: PropTypes.shape({
        id: number,
        title: string,
    }),
};

Show.defaultProps = {
    book: {},
};

export default Show;
