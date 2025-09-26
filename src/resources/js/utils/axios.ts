// src/resources/js/utils/axios.ts
import axios from "axios";

// Laravelサーバー（Nginxコンテナ）のURLをベースに設定
axios.defaults.baseURL = "http://localhost:8080";

// Cookie 認証を使うために必須
axios.defaults.withCredentials = true;

export default axios;
