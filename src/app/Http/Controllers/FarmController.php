<?php

namespace App\Http\Controllers;

use App\Http\Requests\Farms\FarmStoreRequest;
use App\Models\Farm;
use App\Models\State;
use App\Repositories\Farms\FarmRepositoryInterface;
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
    public function index(Request $request): Response
    {
        $keyword = $request->input('keyword');
        $stateName = $request->input('stateName');

        $query = Farm::with(['images' => function($q) {
            $q->orderBy('id')->limit(1);
        }, 'state']);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%");
            });
        }

        if (!empty($stateName)) {
            $stateId = State::where('name', $stateName)->value('id');
        }
        if(!empty($stateId)) {
            $query->where('state_id', $stateId);
        }

        $farms = $query->orderBy('id')->get();

        $states = State::orderBy('id')->get();

        return Inertia::render('Home', [
            'farms' => $farms,
            'states' => $states,
            'keyword' => $keyword,
            'stateName' => $stateName,
        ]);


        // $farms = $this->farmRepository->getAllFarmsWithImageIfExist([
        //     'images' => function ($query) {
        //         $query->orderBy('id')->limit(1);
        //     },
        // ]);

        // return Inertia::render('Home', [
        //     'farms'     => $farms,
        // ]);
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
