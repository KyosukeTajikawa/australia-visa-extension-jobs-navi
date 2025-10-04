<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Repositories\FarmRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FarmController extends Controller
{

    /**
     * FarmController constructor
     * @param FarmRepositoryInterface $farmRepository ファーム情報を扱うリポジトリの実装
     */
    public function __construct(
        private readonly FarmRepositoryInterface $farmRepository
    ) {}

    /**
     * 農場の一覧ページを表示
     * @return Response
     */
    public function index(): Response
    {
        $farms = $this->farmRepository->getAllFarms();

        return Inertia::render('Home', [
            'farms' => $farms,
        ]);
    }

    /**
     * ファーム詳細ページの表示
     * @param int $id ファームID
     * @return Response
     */
    public function detail(int $id): Response
    {
        $farm = $this->farmRepository->getDetailById($id, ['reviews', 'state']);

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
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {


        $validated = $request->validate(
            [
                'name'            => ['required', 'string', 'max:50'],
                'phone_number'    => ['nullable', 'string', 'max:15'],
                'email'           => ['nullable', 'email:rfc', 'max:255'],
                'street_address'  => ['required', 'string', 'max:100'],
                'suburb'          => ['required', 'string', 'max:50'],
                'postcode'        => ['required',  'digits:4'],
                'state_id'        => ['required', 'exists:states,id'],
            ],
            [
                'name.required'           => 'ファーム名は必須です。',
                'email.email'             => 'メールアドレスの形式が正しくありません。',
                'street_address.required' => '住所を入力してください。',
                'suburb.required'         => '地域を入力してください。',
                'postcode.required'       => '郵便番号は必須です。',
                'postcode.digits'         => '郵便番号は4桁の数字で入力してください。',
                'state_id.required'       => '州を選択してください。',
            ]
        );

        $validated['created_user_id'] = $request->user()->id;

        $farm = Farm::create($validated);

        return redirect()->route('farm.detail', ['id' => $farm->id,]);
    }
}
