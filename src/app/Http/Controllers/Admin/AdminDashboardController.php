<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\Review;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    /**
     * 管理者ページを表示
     */
    public function index(): Response
    {
        $farmCount = Farm::count();
        $reviewCount = Review::count();
        $userCount = User::count();
        $latestFarms = Farm::orderBy('created_at', 'desc')->limit(5)->get(['id', 'name', 'created_at']);;
        $latestReviews = Review::orderBy('created_at', 'desc')->limit(5)->with('farm')
            ->get(['id', 'farm_id', 'farm_rating', 'created_at']);;

        return Inertia::render('Admin/Dashboard', [
            'farmCount' => $farmCount,
            'reviewCount' => $reviewCount,
            'userCount' => $userCount,
            'latestFarms' => $latestFarms,
            'latestReviews' => $latestReviews,
        ]);
    }
}
