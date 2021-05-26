import React from "react";
import { useForm } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import SubmitButton from "../../Components/Form/SubmitButton";
import Input from "../../Components/Form/Input";

const Register = () => {
    const { data, setData, post, errors, clearErrors, processing } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });

    const fieldChangeHandler = (field, value) => {
        clearErrors(field);
        setData(field, value);
    };

    const submit = (e) => {
        e.preventDefault();
        post("/register");
    };

    return (
        <Main>
            <div className="md:w-1/3">
                <h3 className="mx-2 mb-2 text-3xl text-center md:text-left">
                    Register
                </h3>
                <form onSubmit={submit} className="space-y-2">
                    <div>
                        <Input
                            onChange={(value) =>
                                fieldChangeHandler("name", value)
                            }
                            value={data.name}
                            error={errors.name}
                            label="name"
                        />
                    </div>
                    <div>
                        <Input
                            error={errors.email}
                            label="email / username"
                            value={data.email}
                            onChange={(value) =>
                                fieldChangeHandler("email", value)
                            }
                        />
                    </div>
                    <div>
                        <Input
                            error={errors.password}
                            type="password"
                            value={data.password}
                            label="password"
                            onChange={(value) =>
                                fieldChangeHandler("password", value)
                            }
                        />
                    </div>
                    <div>
                        <Input
                            error={errors.password_confirmation}
                            type="password"
                            value={data.password_confirmation}
                            label="password one.. more .. time"
                            onChange={(value) =>
                                fieldChangeHandler(
                                    "password_confirmation",
                                    value
                                )
                            }
                        />
                    </div>
                    <div className="mx-2">
                        <SubmitButton isProcessing={processing}>
                            Register
                        </SubmitButton>
                    </div>
                </form>
            </div>
        </Main>
    );
};

export default Register;
