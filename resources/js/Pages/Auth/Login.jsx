import React from "react";
import { useForm } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import FormInput from "../../Components/FormInput";
import SubmitButton from "../../Components/SubmitButton";

const Login = () => {
    const { data, setData, post, errors, processing } = useForm({
        email: "",
        password: "",
    });

    return (
        <Main>
            <form
                onSubmit={(e) => {
                    e.preventDefault();
                    post("/login");
                }}
                className="space-y-2"
            >
                <div>
                    <FormInput
                        error={errors.email}
                        type="text"
                        placeholder="email"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                    />
                </div>
                <div>
                    <FormInput
                        error={errors.password}
                        type="password"
                        value={data.password}
                        placeholder="password"
                        onChange={(e) => setData("password", e.target.value)}
                    />
                </div>
                <div>
                    <SubmitButton isProcessing={processing}>Login</SubmitButton>
                </div>
            </form>
        </Main>
    );
};

export default Login;
