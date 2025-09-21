<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FarmController extends Controller
{
    public function index()
    {

        $farms = Farm::get();

        return Inertia::render('Home', [
            'farms' => $farms,
        ]);
    }
}
