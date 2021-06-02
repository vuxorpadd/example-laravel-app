import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import useWishlist from "../Hooks/useWishlist";
import WishlistHeart from "./WishlistHeart";

const WishlistMenuItem = () => {
    const wishlist = useWishlist();

    return (
        <InertiaLink href={route("wishlist.show")}>
            <div className="relative p-3">
                {wishlist.length > 0 && (
                    <div className="bg-green-300 rounded-full py-1 px-2 text-center text-xs absolute right-0 top-0">
                        {wishlist.length}
                    </div>
                )}
                <WishlistHeart active={false} size={8} />
            </div>
        </InertiaLink>
    );
};

export default WishlistMenuItem;
