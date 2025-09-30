<?php

namespace App\Http\Controllers;

use App\Interfaces\FarmRepositoryInterface;
use Inertia\Inertia;
use Inertia\Response;

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
}
