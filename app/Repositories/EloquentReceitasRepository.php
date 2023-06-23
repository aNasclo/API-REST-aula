<?php

namespace App\Repositories;

use App\Models\Receitas;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ReceitasFormRequest;

class EloquentReceitasRepository implements ReceitasRepository
{
    public function add(ReceitasFormRequest $request): Receitas
    {
        return DB::transaction(function () use ($request) {
            $receitas = Receitas::create([
                'descricao' => $request->descricao,
                'valor' => $request->valor,
                'data' => $request->data,
            ]);

            return $receitas;
        });
    }
}