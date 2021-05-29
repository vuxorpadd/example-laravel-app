import React from "react";
import { useForm } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import SubmitButton from "../../Components/Form/SubmitButton";
import Input from "../../Components/Form/Input";
import FileUpload from "../../Components/Form/FileUpload";
import Text from "../../Components/Form/Text";
import useUploadPreview from "../../Hooks/useUploadPreview";
import ImagePreview from "../../Components/ImagePreview";
import Date from "../../Components/Form/Date";
import AuthorType from "../../Types/AuthorType";

const Edit = ({ author }) => {
    const { data, setData, post, errors, processing } = useForm({
        name: author.name,
        birthdate: author.birthdate,
        bio: author.bio,
        photo: null,
        _method: "PUT",
    });

    const previewFile = useUploadPreview(data.photo);

    const submit = (e) => {
        e.preventDefault();
        post(route("authors.update", { author }), {
            forceFormData: true,
        });
    };

    return (
        <Main>
            <div className="md:w-1/3 mb-2">
                <h3 className="mx-2 mb-2 text-3xl text-center md:text-left">
                    {data.name}
                </h3>
                <form onSubmit={submit} className="space-y-2">
                    <div>
                        <Input
                            onChange={(value) => setData("name", value)}
                            value={data.name}
                            label="Name"
                            error={errors.name}
                        />
                    </div>
                    <div>
                        <Date
                            onChange={(value) => setData("birthdate", value)}
                            value={data.birthdate}
                            error={errors.birthdate}
                            label="Birthdate"
                        />
                    </div>
                    <div className="space-y-2">
                        <div className="ml-2">
                            {!previewFile ? (
                                <ImagePreview
                                    imageUrl={author.photo_url}
                                    width={300}
                                    height={300}
                                >
                                    Current cover:
                                </ImagePreview>
                            ) : (
                                <ImagePreview
                                    imageUrl={previewFile}
                                    width={300}
                                    height={300}
                                >
                                    <div>New photo preview </div>
                                    <div className="text-gray-300">
                                        we will resize it to fit 300x300
                                        proportions
                                    </div>
                                </ImagePreview>
                            )}
                        </div>
                        <FileUpload
                            buttonLabel="change photo"
                            label="New photo image"
                            accept="image/png, image/jpeg"
                            onChange={(value) => {
                                setData("photo", value);
                            }}
                            error={errors.photo}
                            filename={data.photo ? data.photo.name : ""}
                        />
                    </div>
                    <div>
                        <Text
                            onChange={(value) => setData("bio", value)}
                            value={data.bio}
                            label="Bio"
                            error={errors.bio}
                            cols="30"
                        />
                    </div>
                    <div className="mx-2">
                        <SubmitButton isProcessing={processing}>
                            Update
                        </SubmitButton>
                    </div>
                </form>
            </div>
        </Main>
    );
};

Edit.propTypes = {
    author: AuthorType.isRequired,
};

export default Edit;
