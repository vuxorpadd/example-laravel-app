import React from "react";
import UserType from "../../Types/UserType";
import ProfileAvatar from "./ProfileAvatar";

const ProfileCard = ({ user }) => (
    <div className="flex items-center">
        <ProfileAvatar user={user} />
        <div className="ml-4">
            <div>{user.name}</div>
            <div>{user.email}</div>
        </div>
    </div>
);

ProfileCard.propTypes = {
    user: UserType.isRequired,
};

export default ProfileCard;
