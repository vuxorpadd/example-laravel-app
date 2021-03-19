import { Inertia } from "@inertiajs/inertia";

const authMenuItems = [
    {
        label: "Login",
        href: route("login"),
        role: "notauth",
    },
    {
        label: "Register",
        href: route("register"),
        role: "notauth",
    },
    {
        label: "Logout",
        href: route("logout"),
        action: () => {
            Inertia.post(route("logout"));
        },
        role: "auth",
    },
];

export default authMenuItems;
