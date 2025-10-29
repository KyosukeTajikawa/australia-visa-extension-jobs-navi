<?php

namespace App\Repositories;

use App\Models\State;
use Illuminate\Database\Eloquent\Collection;

interface StateRepositoryInterface
{
    /**
     * すべての州情報を取得する
     * @return Collection<State>
     */
    public function getAll(): Collection;

        /**
     * 州情報を取得する
     * @param string $stateName
     * @return int
     */
    public function homeById(string $stateName): int;
}
