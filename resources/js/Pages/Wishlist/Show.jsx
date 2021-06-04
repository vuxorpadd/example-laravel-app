import React, { useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import Loader from "react-loader-spinner";
import Main from "../../Layouts/Main";
import useWishlist from "../../Hooks/useWishlist";
import BookList from "../../Components/BookList";
import useErrors from "../../Hooks/useErrors";

const Show = () => {
    const [loading, setLoading] = useState(false);
    const [showSuccessMsg, setShowSuccessMsg] = useState(false);

    const wishlist = useWishlist();
    const error = useErrors("wishlist");

    return (
        <Main>
            <div className="space-y-4">
                <h3 className="inline-block text-xl">Wishlist</h3>
                <div className="border-t border-b py-4 border-gray-100 md:space-x-4 space-y-4 md:space-y-2">
                    <div className="inline-block w-full md:w-80">
                        {showSuccessMsg ? (
                            <div className="btn w-full text-white bg-green-400 ">
                                Done! Check your email
                            </div>
                        ) : (
                            <button
                                disabled={loading}
                                className="btn btn-primary w-full"
                                type="button"
                                onClick={() =>
                                    Inertia.post(
                                        route("wishlist.send-to-email"),
                                        {},
                                        {
                                            onStart: () => setLoading(true),
                                            onFinish: () => setLoading(false),
                                            onSuccess: () => {
                                                setShowSuccessMsg(true);
                                                setTimeout(() => {
                                                    setShowSuccessMsg(false);
                                                }, 3000);
                                            },
                                        }
                                    )
                                }
                            >
                                {loading ? (
                                    <Loader
                                        className="inline-block"
                                        type="TailSpin"
                                        height={16}
                                        color="white"
                                    />
                                ) : (
                                    "Send to my email"
                                )}
                            </button>
                        )}
                    </div>
                    <div className="inline-block w-full md:w-auto">
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
                {error && (
                    <div className="text-red-400">
                        The wishlist is empty. There is no need to send an empty
                        email.
                    </div>
                )}
                <div className="block">
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
