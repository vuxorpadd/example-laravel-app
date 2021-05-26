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
            <div className="md:w-1/3">
                <h3 className="mx-2 mb-2 text-3xl text-center md:text-left">
                    Login
                </h3>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        post("/login");
                    }}
                    className="space-y-2"
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
                        <SubmitButton isProcessing={processing}>
                            Login
                        </SubmitButton>
                    </div>
                </form>
            </div>
        </Main>
    );
};

export default Login;
