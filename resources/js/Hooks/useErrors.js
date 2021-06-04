import { usePage } from "@inertiajs/inertia-react";

export default function useErrors(errorFor = null) {
    const {
        props: { errors = {} },
    } = usePage();

    if (errorFor) {
        return errors[errorFor] || null;
    }

    return errors;
}
