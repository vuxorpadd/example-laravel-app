import React from "react";
import { Inertia } from "@inertiajs/inertia";
import Main from "../../Layouts/Main";
import useWishlist from "../../Hooks/useWishlist";
import BookList from "../../Components/BookList";

const Show = () => {
    const wishlist = useWishlist();

    return (
        <Main>
            <div className="space-y-4">
                <h3 className="inline-block text-xl">Wishlist</h3>
                <div className="border-t border-b py-4 border-gray-100 space-x-4">
                    <div className="inline-block">
                        <button
                            className="btn hover:bg-gray-50"
                            type="button"
                            onClick={() =>
                                Inertia.post(route("wishlist.clear"), {
                                    _method: "PUT",
                                })
                            }
                        >
                            Clear
                        </button>
                    </div>
                </div>
                <div>
                    {wishlist.length === 0 ? (
                        <div>Nothing here yet</div>
                    ) : (
                        <BookList books={wishlist} />
                    )}
                </div>
            </div>
        </Main>
    );
};

export default Show;
