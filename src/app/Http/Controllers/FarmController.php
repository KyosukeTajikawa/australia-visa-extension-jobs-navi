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
     * @param FarmServiceInterface $farmService ファーム情報を扱うサービスの実装
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
        $farm = $this->farmRepository->getDetailById($id, ['reviews', 'state', 'images', 'crops']);

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
        $crops = $this->farmRepository->getCrops();

        return Inertia::render('Farm/Create', [
            'states' => $states,
            'crops'  => $crops,
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

        $farmData = Arr::except($validated, ['crop_ids']);
        $cropData = array_map('intval', $validated['crop_ids']);
        $files    = $request->file('files');

        $farm = $this->farmService->store($farmData, $cropData, $files);

        return redirect()->route('farm.detail', [
            'id' => $farm->id,
        ]);
    }
}
