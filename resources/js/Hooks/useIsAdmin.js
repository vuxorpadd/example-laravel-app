import useUser from "./useUser";

export default function useIsAdmin() {
    const user = useUser();

    if (!user || !user.role) {
        return false;
    }

    return user.role === "admin";
}
