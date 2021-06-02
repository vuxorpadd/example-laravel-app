import { usePage } from "@inertiajs/inertia-react";

export default function useWishlist() {
    const {
        props: { wishlist = null },
    } = usePage();

    return wishlist;
}
