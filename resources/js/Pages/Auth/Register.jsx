import React from "react";
import { useForm } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import FormInput from "../../Components/FormInput";
import SubmitButton from "../../Components/SubmitButton";

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
            <div>
                <form onSubmit={submit} className="space-y-2">
                    <div>
                        <FormInput
                            error={errors.name}
                            type="text"
                            placeholder="name"
                            value={data.name}
                            onChange={(e) =>
                                fieldChangeHandler("name", e.target.value)
                            }
                        />
                    </div>
                    <div>
                        <FormInput
                            error={errors.email}
                            type="text"
                            placeholder="email / username"
                            value={data.email}
                            onChange={(e) =>
                                fieldChangeHandler("email", e.target.value)
                            }
                        />
                    </div>
                    <div>
                        <FormInput
                            error={errors.password}
                            type="password"
                            value={data.password}
                            placeholder="password"
                            onChange={(e) =>
                                fieldChangeHandler("password", e.target.value)
                            }
                        />
                    </div>
                    <div>
                        <FormInput
                            error={errors.password_confirmation}
                            type="password_confirmation"
                            value={data.password_confirmation}
                            placeholder="password one.. more .. time"
                            onChange={(e) =>
                                fieldChangeHandler(
                                    "password_confirmation",
                                    e.target.value
                                )
                            }
                        />
                    </div>
                    <div>
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
