<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * ユーザー一覧ページを表示
     */
    public function index(): Response
    {

        $users = User::with(['farms', 'userReviews'])->get();

        return Inertia::render('Admin/User', [
            'users' => $users,
        ]);
    }
}
