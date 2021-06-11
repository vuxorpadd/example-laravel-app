import React, { useState } from "react";
import UserType from "../../Types/UserType";
import ProfileAvatar from "./ProfileAvatar";
import ProfilePopup from "./ProfilePopup";

const ProfileMenuItem = ({ user }) => {
    const [showPopup, setShowPopup] = useState(false);

    const togglePopup = () => {
        setShowPopup(!showPopup);
    };

    const closePopup = () => {
        setShowPopup(false);
    };

    return (
        <div className="relative">
            <button
                type="button"
                onClick={togglePopup}
                className="focus:outline-none"
            >
                <ProfileAvatar user={user} />
            </button>
            {showPopup && <ProfilePopup outsideClickHandler={closePopup} />}
        </div>
    );
};

ProfileMenuItem.propTypes = {
    user: UserType.isRequired,
};

export default ProfileMenuItem;
