import useIsAdmin from "../Hooks/useIsAdmin";

const AdminOnly = ({ children }) => {
    const isAdmin = useIsAdmin();
    return isAdmin && children;
};

export default AdminOnly;
