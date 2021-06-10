import { Inertia } from "@inertiajs/inertia";

const authMenuItems = [
    {
        id: "login",
        label: "Login",
        href: route("login"),
        role: "notauth",
        components: ["Auth/Login"],
    },
    {
        id: "register",
        label: "Register",
        href: route("register"),
        role: "notauth",
        components: ["Auth/Register"],
    },
    {
        id: "logout",
        label: "Logout",
        href: route("logout"),
        action: () => {
            Inertia.post(route("logout"));
        },
        role: "auth",
    },
];

export default authMenuItems;
