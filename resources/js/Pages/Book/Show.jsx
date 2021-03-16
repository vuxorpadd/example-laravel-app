import React from "react";
import PropTypes, { number, string } from "prop-types";
import Main from "../../Layouts/Main";

const Show = ({ book }) => (
    <Main>
        <div>{book.title}</div>
    </Main>
);

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
