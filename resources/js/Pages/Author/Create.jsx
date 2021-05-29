import React from "react";
import { useForm } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import SubmitButton from "../../Components/Form/SubmitButton";
import Input from "../../Components/Form/Input";
import FileUpload from "../../Components/Form/FileUpload";
import Text from "../../Components/Form/Text";
import useUploadPreview from "../../Hooks/useUploadPreview";
import AuthorPhotoPreview from "../../Components/AuthorPhotoPreview";
import ResizeNotice from "../../Components/ResizeNotice";
import { AUTHOR_PHOTO_H, AUTHOR_PHOTO_W } from "../../Constants/general";
import DateInput from "../../Components/Form/DateInput";

const Create = () => {
    const { data, setData, post, errors, processing } = useForm({
        name: "",
        birthdate: new Date(),
        bio: "",
        photo: "",
    });

    const previewFile = useUploadPreview(data.photo.name ? data.photo : null);

    const submit = (e) => {
        e.preventDefault();
        post(route("authors.store"), {
            forceFormData: true,
        });
    };

    return (
        <Main>
            <div className="md:w-1/3 mb-2">
                <h3 className="mx-2 mb-2 text-3xl text-center md:text-left">
                    New author
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
                        <DateInput
                            onChange={(value) => setData("birthdate", value)}
                            value={data.birthdate}
                            error={errors.birthdate}
                            label="Birthdate"
                        />
                    </div>
                    <div className="ml-2">
                        {previewFile && (
                            <AuthorPhotoPreview imageUrl={previewFile}>
                                <div>Photo preview</div>
                                <ResizeNotice
                                    height={AUTHOR_PHOTO_H}
                                    width={AUTHOR_PHOTO_W}
                                />
                            </AuthorPhotoPreview>
                        )}
                    </div>
                    <div>
                        <FileUpload
                            label="Photo"
                            accept="image/png, image/jpeg"
                            onChange={(value) => {
                                setData("photo", value);
                            }}
                            error={errors.photo}
                            filename={data.photo.name ?? ""}
                        />
                    </div>
                    <div>
                        <Text
                            onChange={(value) => setData("bio", value)}
                            value={data.bio}
                            label="Bio"
                            error={errors.bio}
                            rows="15"
                        />
                    </div>
                    <div className="mx-2">
                        <SubmitButton isProcessing={processing}>
                            Add
                        </SubmitButton>
                    </div>
                </form>
            </div>
        </Main>
    );
};

export default Create;
