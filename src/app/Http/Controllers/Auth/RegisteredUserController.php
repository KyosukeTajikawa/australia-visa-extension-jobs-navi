<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserStoreRequest;
use App\Http\Requests\Auth\UserUpdateRequest;
use App\Models\UserImage;
use App\Repositories\Auth\UserRepositoryInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserServiceInterface $userService,
    ) {}

    /**
     * ユーザー登録ページの表示
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * ユーザーの新規登録
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $file = $request->file('file');

        $user = $this->userService->update($validated, $file);

        Auth::login($user);
        return redirect()->route('home');
    }

    /**
     * ユーザー編集画面の表示
     * @return Response
     */
    public function edit(): Response
    {
        $user = auth()->user();

        return Inertia::render('Auth/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * ユーザーの編集
     * @param UserUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $file = $request->file('file');

        $user = $this->userService->update($validated, $file);

        return redirect()->route('home');
    }
}
