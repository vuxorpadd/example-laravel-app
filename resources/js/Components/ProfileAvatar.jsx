import React from "react";
import UserType from "../Types/UserType";

const ProfileAvatar = ({ user }) => (
    <div className="inline-block py-1 px-3 w-8 h-8 text-white bg-gray-700 rounded-full ring-2 ring-gray-200">
        {user.name[0]}
    </div>
);

ProfileAvatar.propTypes = {
    user: UserType.isRequired,
};

export default ProfileAvatar;
