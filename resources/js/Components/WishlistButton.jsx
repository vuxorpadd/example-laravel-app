import React from "react";
import { Inertia } from "@inertiajs/inertia";
import useWishlist from "../Hooks/useWishlist";
import BookType from "../Types/BookType";
import WishlistHeart from "./WishlistHeart";

const WishlistButton = ({ book }) => {
    const wishlist = useWishlist();

    const active = wishlist
        ? wishlist.find((wishlistBook) => wishlistBook.id === book.id)
        : false;

    return (
        <button
            type="button"
            className="text-white hover:bg-gray-50 focus:outline-none focus:bg-initial"
            onClick={() => {
                Inertia.post(
                    route("wishlist.addremove", { book }),
                    {
                        _method: "PUT",
                    },
                    { preserveScroll: true, only: ["wishlist"] }
                );
            }}
        >
            <WishlistHeart active={active} size={6} />
        </button>
    );
};

WishlistButton.propTypes = {
    book: BookType.isRequired,
};

export default WishlistButton;
