<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FarmController extends Controller
{
    /**
     * 農場の一覧ページを表示
     * @return Response
     */
    public function index(): Response
    {
        $farms = Farm::get();

        return Inertia::render('Home', [
            'farms' => $farms,
        ]);
    }

    public function detail($id)
    {
        $farm = Farm::with('reviews', 'state')->find($id);

        // dd($farm);

        return Inertia::render('Farm/Detail', [
            'farm' => $farm,
        ]);
    }
}
