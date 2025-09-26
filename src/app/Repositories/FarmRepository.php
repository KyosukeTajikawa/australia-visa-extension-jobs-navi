<?php

namespace App\Repositories;

use App\Models\Farm;
use App\Interfaces\FarmRepositoryInterface;

class FarmRepository implements FarmRepositoryInterface
{
    public function getAllFarms()
    {
        return Farm::get();
    }

    public function getDetailById(int $id)
    {
        return Farm::with('reviews', 'state')->find($id);
    }
}
