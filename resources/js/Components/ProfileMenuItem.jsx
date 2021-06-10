import React, { useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import UserType from "../Types/UserType";
import ProfileAvatar from "./ProfileAvatar";
import ProfileCard from "./ProfileCard";

const ProfileMenuItem = ({ user }) => {
    const [showPopup, setShowPopup] = useState(false);

    const logout = () => Inertia.post(route("logout"));

    return (
        <div className="relative">
            <button
                type="button"
                onClick={() => setShowPopup(!showPopup)}
                className="focus:outline-none"
            >
                <ProfileAvatar user={user} />
            </button>
            {showPopup && (
                <div className="absolute right-0 bg-gray-100 top-10 w-80 border border-gray-200 rounded-md shadow-md">
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
            )}
        </div>
    );
};

ProfileMenuItem.propTypes = {
    user: UserType.isRequired,
};

export default ProfileMenuItem;
