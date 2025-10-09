<?php

namespace App\Services;

use App\Models\Farm;

interface FarmServiceInterface
{
    public function store(array $validated, ?array $files = null):Farm ;
}
