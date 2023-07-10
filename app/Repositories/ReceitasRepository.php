<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Receitas;
use App\Http\Requests\ReceitasFormRequest;

interface ReceitasRepository
{
    public function add(ReceitasFormRequest $request, User $user): Receitas;
}