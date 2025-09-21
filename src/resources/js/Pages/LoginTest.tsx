import React from "react";
import { useForm, router } from "@inertiajs/react";

export default function LoginTest() {
    const { data, setData, post, processing, errors } = useForm({
        email: "",
        password: "",
    });

    function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        post(route("login"));
    }

    function handleLogout() {
        router.post(route("logout"));
    }

    return (
        <div style={{ maxWidth: "400px", margin: "40px auto", textAlign: "center" }}>
            <h2>Login Test</h2>

            <form onSubmit={handleSubmit}>
                <div style={{ marginBottom: "10px" }}>
                    <input
                        type="email"
                        placeholder="Email"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                        style={{ width: "100%", padding: "8px" }}
                    />
                    {errors.email && <p style={{ color: "red" }}>{errors.email}</p>}
                </div>

                <div style={{ marginBottom: "10px" }}>
                    <input
                        type="password"
                        placeholder="Password"
                        value={data.password}
                        onChange={(e) => setData("password", e.target.value)}
                        style={{ width: "100%", padding: "8px" }}
                    />
                    {errors.password && <p style={{ color: "red" }}>{errors.password}</p>}
                </div>

                <div style={{ marginBottom: "10px" }}>
                    <button
                        type="submit"
                        disabled={processing}
                        style={{ width: "100%", padding: "10px", background: "blue", color: "white" }}
                    >
                        {processing ? "Logging in..." : "Login"}
                    </button>
                </div>
            </form>

            {/* ログアウトボタン */}
            <div style={{ marginBottom: "10px" }}>
                <button
                    onClick={handleLogout}
                    style={{ width: "100%", padding: "10px", background: "red", color: "white" }}
                >
                    Logout
                </button>
            </div>
        </div>
    );
}
