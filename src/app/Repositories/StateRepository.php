<?php

namespace App\Repositories;

use App\Models\State;
use App\Repositories\StateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StateRepository implements StateRepositoryInterface
{
    /**
     * すべての州情報を取得する
     * @return Collection<State>
     */
    public function getAll(): Collection
    {
        return State::orderBy('id')->get();
    }

    /**
     * 州情報を取得する
     * @param string $stateName
     * @return int
     */
    public function homeById(string $stateName): ?int
    {
        return (int) State::where('name', $stateName)->value('id');
    }
}
