import React from "react";
import Main from "../../Layouts/Main";
import AuthorType from "../../Types/AuthorType";
import AuthorForm from "../../Components/AuthorForm/AuthorForm";

const Edit = ({ author }) => (
    <Main>
        <div className="md:w-1/3 mb-2">
            <AuthorForm
                defaults={{
                    name: author.name,
                    birthdate: new Date(author.birthdate),
                    bio: author.bio || "",
                    photo: null,
                    _method: "PUT",
                }}
            >
                <AuthorForm.UpdateAuthor author={author}>
                    <AuthorForm.Header />
                    <AuthorForm.Body>
                        <AuthorForm.Name />
                        <AuthorForm.Birthdate />
                        <AuthorForm.PhotoPreview />
                        <AuthorForm.PhotoUpload />
                        <AuthorForm.Bio />
                        <AuthorForm.SubmitBtn>Update</AuthorForm.SubmitBtn>
                    </AuthorForm.Body>
                </AuthorForm.UpdateAuthor>
            </AuthorForm>
        </div>
    </Main>
);

Edit.propTypes = {
    author: AuthorType.isRequired,
};

export default Edit;
