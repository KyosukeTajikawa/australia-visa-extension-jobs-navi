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

    public function create(int $id)
    {
        $farm = Farm::select('id', 'name')->findOrFail($id);

        return Inertia::render('Review/Create',[
            'farm' => $farm,
        ]);
    }
}
