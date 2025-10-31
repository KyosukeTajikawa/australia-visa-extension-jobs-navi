<?php

namespace App\Http\Controllers;

use App\Http\Requests\Farms\FarmStoreRequest;
use App\Models\State;
use App\Repositories\Farms\FarmRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\FarmServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;

class FarmController extends Controller
{

    /**
     * FarmController constructor
     * @param FarmRepositoryInterface $farmRepository ファーム情報を扱うリポジトリの実装
     * @param StateRepositoryInterface $stateRepository 州情報を扱うリポジトリの実装
     * @param FarmServiceInterface $farmService ファーム情報を扱うサービスの実装
     */
    public function __construct(
        private readonly FarmRepositoryInterface $farmRepository,
        private readonly StateRepositoryInterface $stateRepository,
        private readonly FarmServiceInterface $farmService
    ) {}

    /**
     * 農場の一覧ページを表示
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $keyword = $request->input('keyword' ?? '');
        $stateName = $request->input('stateName' ?? '');

        $states = $this->stateRepository->getAll();

        $data = $this->farmRepository->getAllFarmsWithImageAndSearch($keyword, $stateName);

        $farms = $data['farms'];
        $keyword = $data['keyword'];
        $stateName = $data['stateName'];

        return Inertia::render('Home', [
            'farms' => $farms,
            'states' => $states,
            'keyword' => $keyword,
            'stateName' => $stateName,
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
        $crops = $this->farmRepository->getCrops();

        $states = $this->stateRepository->getAll();

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
        $validated['created_user_id'] = auth()->id();

        $farmData = Arr::except($validated, ['crop_ids']);
        $cropData = array_map('intval', $validated['crop_ids']);
        $files    = $request->file('files');

        $farm = $this->farmService->store($farmData, $cropData, $files);

        return redirect()->route('farm.detail', [
            'id' => $farm->id,
        ]);
    }
}
