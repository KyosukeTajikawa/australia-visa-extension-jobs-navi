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

    /**
     * ユーザー詳細ページを表示
     */
    public function detail(int $id): Response
    {

        $user = User::with(['farms', 'userReviews.farm'])->findOrFail($id);

        return Inertia::render('Admin/Detail', [
            'user' => $user,
        ]);
    }
}
