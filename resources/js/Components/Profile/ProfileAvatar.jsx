import React from "react";
import UserType from "../../Types/UserType";

const ProfileAvatar = ({ user }) => (
    <div className="text-white bg-gray-700 rounded-full ring-2 ring-gray-200 p-2">
        <div className="h-4 w-4 flex items-center">
            <span className="mx-auto">{user.name[0]}</span>
        </div>
    </div>
);

ProfileAvatar.propTypes = {
    user: UserType.isRequired,
};

export default ProfileAvatar;
