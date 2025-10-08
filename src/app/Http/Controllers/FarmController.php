<?php

namespace App\Http\Controllers;

use App\Http\Requests\Farms\FarmStoreRequest;
use App\Repositories\FarmRepositoryInterface;
use App\Services\FarmServiceInterface;
use Illuminate\Http\RedirectResponse;

use Inertia\Inertia;
use Inertia\Response;


class FarmController extends Controller
{

    /**
     * FarmController constructor
     * @param FarmRepositoryInterface $farmRepository ファーム情報を扱うリポジトリの実装
     * @param FarmServiceInterface $farmService ファーム情報を扱うリポジトリの実装
     */
    public function __construct(
        private readonly FarmRepositoryInterface $farmRepository,
        private readonly FarmServiceInterface $farmService
    ) {}

    /**
     * 農場の一覧ページを表示
     * @return Response
     */
    public function index(): Response
    {
        $farms = $this->farmRepository->getAllFarmsWithImageIfExist([
            'images' => function ($query) {
                $query->orderBy('id')->limit(1);
            },
        ]);

        return Inertia::render('Home', [
            'farms'     => $farms,
        ]);
    }

    /**
     * ファーム詳細ページの表示
     * @param int $id ファームID
     * @return Response
     */
    public function detail(int $id): Response
    {
        $farm = $this->farmRepository->getDetailById($id, ['reviews', 'state', 'images']);

        return Inertia::render('Farm/Detail', [
            'farm' => $farm,
        ]);
    }

    /**
     * ファーム新規作成のページを表示
     * @return Response
     */
    public function create(): Response
    {
        $states = $this->farmRepository->getStates();

        return Inertia::render('Farm/Create', [
            'states' => $states,
        ]);
    }

    /**
     * ファームの新規登録
     * @param FarmStoreRequest $request
     * @return RedirectResponse
     */
    public function store(FarmStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $farm = $this->farmService->store($validated, $request->file('files'));

        return redirect()->route('farm.detail', [
            'id' => $farm->id,
        ]);
<<<<<<< HEAD
=======


        $validated = $request->validate(
            [
                'name'            => ['required', 'string', 'max:50'],
                'phone_number'    => ['nullable', 'string', 'regex:/^\d{10,11}$/'],
                'email'           => ['nullable', 'email:rfc', 'max:255'],
                'street_address'  => ['required', 'string', 'max:100'],
                'suburb'          => ['required', 'string', 'max:50'],
                'postcode'        => ['required',  'digits:4'],
                'state_id'        => ['required', 'integer', 'exists:states,id'],
                'description'     => ['nullable', 'string', 'max:1000'],
                'files'           => ['nullable', 'array', ],
                'files.*'         => ['image', 'mimes:jpg,jpeg,png', 'max:5120'],
            ],
            [
                'name.required'           => 'ファーム名は必須です。',
                'phone_number.regex'      => '電話番号はハイフンなしの数字10桁,11桁で入力してください。',
                'email.email'             => 'メールアドレスの形式が正しくありません。',
                'street_address.required' => '住所を入力してください。',
                'suburb.required'         => '地域を入力してください。',
                'postcode.required'       => '郵便番号は必須です。',
                'postcode.digits'         => '郵便番号は4桁の数字で入力してください。',
                'state_id.required'       => '州を選択してください。',
                'file.*.image'            => '画像ファイルを選択してください。',
                'file.*.mimes'            => 'jpg/jpeg/png のいずれかを選択してください。',
                'file.*.max'              => '画像サイズは5MB以下にしてください。',
            ]
        );

        $validated['created_user_id'] = $request->user()->id;

        DB::beginTransaction();
        try {
            $farm = Farm::create($validated);

            if ($request->hasFile('files')) {
                $files = $request->file('files');

                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $name = (string)Str::uuid() . '.' . $extension;
                    $dir = "farms/{$farm->id}";

                    $path = Storage::disk('s3')->putFileAs($dir, $file, $name, file_get_contents($file), ['visibility' => 'public']);

                    /** @var \Illuminate\Filesystem\FilesystemAdapter $s3 */
                    $s3 = Storage::disk('s3');
                    $url = $s3->url($path);

                    FarmImages::create([
                        'farm_id' => $farm->id,
                        'url'     => $url,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            Log::error($message);
            DB::rollBack();
            throw $e;
        }


        return redirect()->route('farm.detail', [
            'id' => $farm->id,
        ]);
>>>>>>> 4b982b9 (ファーム一覧ページに画像を表示する機能の追加)
    }
}
