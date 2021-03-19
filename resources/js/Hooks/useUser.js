import { usePage } from "@inertiajs/inertia-react";

export default function useUser() {
    const {
        props: { user = null },
    } = usePage();

    return user;
}
