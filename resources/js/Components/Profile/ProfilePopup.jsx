import React from "react";
import { useDetectClickOutside } from "react-detect-click-outside";
import { Inertia } from "@inertiajs/inertia";
import PropTypes from "prop-types";
import ProfileCard from "./ProfileCard";
import useUser from "../../Hooks/useUser";

const ProfilePopup = ({ outsideClickHandler }) => {
    const user = useUser();
    const logout = () => Inertia.post(route("logout"));

    const ref = useDetectClickOutside({
        onTriggered: outsideClickHandler,
    });

    return (
        <div
            className="absolute right-0 bg-gray-100 top-10 w-80 border border-gray-200 rounded-md shadow-md"
            ref={ref}
        >
            <div className="bg-white p-4 border-b">
                <ProfileCard user={user} />
            </div>
            <div className="bg-white p-4 flex">
                <div className="mx-auto">
                    <button
                        type="button"
                        className="btn shadow-none border"
                        onClick={logout}
                    >
                        Logout
                    </button>
                </div>
            </div>
        </div>
    );
};

ProfilePopup.propTypes = {
    outsideClickHandler: PropTypes.func,
};

ProfilePopup.defaultProps = {
    outsideClickHandler: null,
};

export default ProfilePopup;
