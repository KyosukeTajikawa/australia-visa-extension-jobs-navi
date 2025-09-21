// src/resources/js/api/auth.ts
import axios from "../utils/axios";

// ログイン処理
export async function login(email: string, password: string) {
    // CSRF Cookie を取得
    await axios.get("/sanctum/csrf-cookie");

    // メールとパスワードを送信
    const res = await axios.post("/login", { email, password });
    return res.data;
}

// 現在のログインユーザーを取得
export async function getUser() {
    const res = await axios.get("/api/user");
    return res.data;
}

// ログアウト処理
export async function logout() {
    const res = await axios.post("/logout");
    return res.data;
}
