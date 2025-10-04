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

    $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'phone_number'    => ['nullable', 'string', 'max:15'],
            'email'           => ['nullable', 'email:rfc', 'max:255'],
            'street_address'  => ['required', 'string', 'max:100'],
            'suburb'          => ['required', 'string', 'max:50'],
            'postcode'        => ['required', 'digits:4'],
            'state_id'        => ['required', 'exists:states,id'],
        ]);

        $validated['created_user_id'] = $request->user()->id;

        $farm = Farm::create($validated);

        return redirect()->route('farm.detail', ['id' => $farm->id,]);
    }
}
