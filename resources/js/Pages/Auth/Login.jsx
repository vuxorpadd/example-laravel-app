import React from "react";
import { useForm } from "@inertiajs/inertia-react";
import Main from "../../Layouts/Main";
import SubmitButton from "../../Components/Form/SubmitButton";
import Input from "../../Components/Form/Input";

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
                className="space-y-2 md:w-1/3"
            >
                <div>
                    <Input
                        error={errors.email}
                        label="email"
                        value={data.email}
                        onChange={(value) => setData("email", value)}
                    />
                </div>
                <div>
                    <Input
                        type="password"
                        error={errors.password}
                        value={data.password}
                        label="password"
                        onChange={(value) => setData("password", value)}
                    />
                </div>
                <div className="mx-2">
                    <SubmitButton isProcessing={processing}>Login</SubmitButton>
                </div>
            </form>
        </Main>
    );
};

export default Login;
