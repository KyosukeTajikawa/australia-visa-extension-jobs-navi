<?php

namespace App\Interfaces;

interface FarmRepositoryInterface
{
    public function getAllFarms();
    public function getDetailById(int $id);
}
