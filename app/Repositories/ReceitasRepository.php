<?php

namespace App\Repositories;

use App\Models\Receitas;
use App\Http\Requests\ReceitasFormRequest;

interface ReceitasRepository
{
    public function add(ReceitasFormRequest $request): Receitas;
}