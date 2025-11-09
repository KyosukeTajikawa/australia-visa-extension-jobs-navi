<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserStoreRequest;
use App\Http\Requests\Auth\UserUpdateRequest;
use App\Models\UserImage;
use App\Models\UserImages;
use App\Repositories\Auth\UserRepositoryInterface;
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

        DB::beginTransaction();
        try {
            $user = $this->userRepository->registerUser($validated);

            if ($file) {
                $name = $file->getClientOriginalName();
                $path = Storage::disk('s3')->putFileAs("users/{$user->id}", $file, $name);
                $url = Storage::disk('s3')->url($path);

                UserImage::create([
                    'user_id' => $user->id,
                    'url' => $url,
                    'path' => $path,
                ]);
            }
            DB::commit();

            Auth::login($user);
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error(__METHOD__ . 'ファームの登録処理でエラーが発生しました。' . $e->getMessage());
            DB::rollBack();
            throw $e;
        }
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

        $user = auth()->user();

        $this->userRepository->updateUser($validated, $user);

        return redirect(route('home', absolute: false));
    }
}
