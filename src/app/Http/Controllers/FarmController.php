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
        $farms = $this->farmRepository->getAllFarms([
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
     * @return RedirectResponse
     */
    public function store(FarmStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['created_user_id'] = $request->user()->id;


        $files = $request->file('files');
        $farm = $this->farmService->store($validated, $files);

        return redirect()->route('farm.detail', [
            'id' => $farm->id,
        ]);
    }
}
