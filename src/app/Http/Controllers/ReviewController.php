<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Repositories\FarmRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
{
    /**
     * FarmController constructor
     * @param FarmRepositoryInterface $farmRepository ファーム情報を扱うリポジトリの実装
     */
    public function __construct(
        private readonly FarmRepositoryInterface $farmRepository,
    ){}

    /**
     * ファーム新規作成のページを表示
     * @return Response
     */
    public function create(int $id): Response
    {
        $farm = Farm::select('id', 'name')->findOrFail($id);

        return Inertia::render('Review/Create',[
            'farm' => $farm,
        ]);
    }

    public function store()
    {

    }
}
