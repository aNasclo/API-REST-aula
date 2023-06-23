<?php

namespace App\Repositories;

use App\Models\Despesas;
use App\Http\Requests\DespesasFormRequest;

interface DespesasRepository
{
    public function add(DespesasFormRequest $request): Despesas;
}