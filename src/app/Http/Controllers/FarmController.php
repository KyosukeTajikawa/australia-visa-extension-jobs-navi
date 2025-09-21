<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FarmController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $farms = Farm::get();
=======
        $farms = Farm::with('review')->get();
>>>>>>> 75a7975 (controller route 作成)
        // dd($farms);
        return Inertia::render('Home', [
            'farms' => $farms,
        ]);
    }
}
