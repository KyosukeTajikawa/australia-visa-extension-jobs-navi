<?php

return [
    'required' => ':attribute は必須です。',
    'email' => ':attribute の形式が正しくありません。',
    'confirmed' => ':attribute が一致していません。',

    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード（確認）',
        'token' => 'パスワード再設定トークン',
    ],
];
