<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserStoreRequest;
use App\Http\Requests\Auth\UserUpdateRequest;
use App\Repositories\Auth\UserImageRepositoryInterface;
use App\Repositories\Auth\UserRepositoryInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{

    public function __construct(
        private readonly UserImageRepositoryInterface $userImageRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserServiceInterface $userService,
    ) {}

    /**
     * プロフィール表示
     * @return Response
     */
    public function index(): Response
    {
        $user = $this->userRepository->getUser(['image']);

        return Inertia::render('Auth/Profile', [
            'user' => $user,
        ]);
    }

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

        $user = $this->userService->store($validated, $file);

        Auth::login($user);
        return redirect()->route('home');
    }

    /**
     * ユーザー編集画面の表示
     * @return Response
     */
    public function edit(): Response
    {
        $user = auth()->user()->load('image');

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

        return redirect()->route('profile');
    }

    /**
     * ユーザー画像を削除
     * @param int $id
     * @return RedirectResponse
     */
    public function imageDestroy(int $id): RedirectResponse
    {
        $image = $this->userRepository->getImage($id);

            Storage::disk('s3')->delete($image->path);
            $image->delete();

            return redirect()->route('profile');
    }

    /**
     * ユーザー削除
     * @return RedirectResponse
     */
    public function destroy(): RedirectResponse
    {
        $this->userRepository->destroyUser();

        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $status = "delete_success";

        return redirect()->route('home', [
            'status' => $status,
        ]);
    }
}
