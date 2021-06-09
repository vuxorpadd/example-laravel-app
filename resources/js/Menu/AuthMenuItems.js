import { Inertia } from "@inertiajs/inertia";

const authMenuItems = [
    {
        label: "Login",
        href: route("login"),
        role: "notauth",
        components: ["Auth/Login"],
    },
    {
        label: "Register",
        href: route("register"),
        role: "notauth",
        components: ["Auth/Register"],
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
