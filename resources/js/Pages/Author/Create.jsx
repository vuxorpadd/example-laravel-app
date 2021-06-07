import React from "react";
import Main from "../../Layouts/Main";
import AuthorForm from "../../Components/AuthorForm/AuthorForm";

const Create = () => (
    <Main>
        <div className="md:w-1/3 mb-2">
            <AuthorForm
                defaults={{
                    name: "",
                    birthdate: new Date(),
                    bio: "",
                    photo: "",
                }}
            >
                <AuthorForm.CreateAuthor>
                    <AuthorForm.Header>New author</AuthorForm.Header>
                    <AuthorForm.Body>
                        <AuthorForm.Name />
                        <AuthorForm.Birthdate />
                        <AuthorForm.PhotoPreview />
                        <AuthorForm.PhotoUpload />
                        <AuthorForm.Bio />
                        <AuthorForm.SubmitBtn>Add</AuthorForm.SubmitBtn>
                    </AuthorForm.Body>
                </AuthorForm.CreateAuthor>
            </AuthorForm>
        </div>
    </Main>
);

export default Create;
