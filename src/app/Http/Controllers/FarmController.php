<?php

namespace App\Http\Controllers;

use App\Interfaces\FarmRepositoryInterface;
use App\Models\Farm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
// use Illuminate\Http\Response;

class FarmController extends Controller
{
    private FarmRepositoryInterface $farmRepository;

    public function __construct(FarmRepositoryInterface $farmRepository)
    {
        $this->farmRepository = $farmRepository;
    }


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

    public function detail(int $id)
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
        return Inertia::render('Farm/Create');
    }
}
