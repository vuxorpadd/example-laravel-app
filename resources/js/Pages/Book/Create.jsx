import React from "react";
import { arrayOf } from "prop-types";
import { useForm } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import SubmitButton from "../../Components/Form/SubmitButton";
import Input from "../../Components/Form/Input";
import AuthorType from "../../Types/AuthorType";
import FileUpload from "../../Components/Form/FileUpload";
import Select from "../../Components/Form/Select";
import Text from "../../Components/Form/Text";

const Create = ({ authors }) => {
    const { data, setData, post, errors, processing } = useForm({
        title: "",
        author_id: authors[0].id ?? "",
        cover: "",
        subtitle: "",
        description: "",
        preview: "",
    });

    const submit = (e) => {
        e.preventDefault();
        post(route("books.store"), {
            forceFormData: true,
        });
    };

    return (
        <Main>
            <form onSubmit={submit} className="space-y-2 md:w-1/3 mb-2">
                <div>
                    <Input
                        onChange={(value) => setData("title", value)}
                        value={data.title}
                        label="Title"
                        error={errors.title}
                    />
                </div>
                <div>
                    <Select
                        value={data.author_id}
                        onChange={(value) => setData("author_id", value)}
                        error={errors.author_id}
                        options={authors.map(({ id, name }) => ({
                            value: id,
                            label: name,
                        }))}
                    />
                </div>
                <div>
                    <FileUpload
                        label="Cover image"
                        accept="image/png, image/jpeg"
                        onChange={(value) => {
                            setData("cover", value);
                        }}
                        error={errors.cover}
                        filename={data.cover.name ?? ""}
                    />
                </div>
                <div>
                    <Text
                        onChange={(value) => setData("subtitle", value)}
                        value={data.subtitle}
                        label="Subtitle"
                        error={errors.subtitle}
                        cols="30"
                    />
                </div>
                <div>
                    <Text
                        onChange={(value) => setData("preview", value)}
                        value={data.preview}
                        label="Preview"
                        error={errors.preview}
                        rows="7"
                    />
                </div>
                <div>
                    <Text
                        onChange={(value) => setData("description", value)}
                        value={data.description}
                        label="Description"
                        error={errors.description}
                        rows="15"
                    />
                </div>
                <div className="mx-2">
                    <SubmitButton isProcessing={processing}>Add</SubmitButton>
                </div>
            </form>
        </Main>
    );
};

Create.propTypes = {
    authors: arrayOf(AuthorType),
};

Create.defaultProps = {
    authors: [],
};

export default Create;
