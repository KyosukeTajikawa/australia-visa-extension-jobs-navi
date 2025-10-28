<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface StateRepositoryInterface
{
    /**
     * すべての州情報を取得する
     * @return Collection<State>
     */
    public function getAll(): Collection;
}
