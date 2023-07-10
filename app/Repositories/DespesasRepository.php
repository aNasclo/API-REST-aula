<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Despesas;
use App\Http\Requests\DespesasFormRequest;

interface DespesasRepository
{
    public function add(DespesasFormRequest $request, User $user): Despesas;
}