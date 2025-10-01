<?php

namespace App\Http\Controllers;

use App\Interfaces\FarmRepositoryInterface;
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
 * @return Response
 */
    public function detail(int $id): Response
    {
        $farm = $this->farmRepository->getDetailById($id);

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
}
