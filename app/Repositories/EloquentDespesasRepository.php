<?php

namespace App\Repositories;

use App\Models\Despesas;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DespesasFormRequest;

class EloquentDespesasRepository implements DespesasRepository
{
    public function add(DespesasFormRequest $request): Despesas
    {
        return DB::transaction(function () use ($request) {
            $despesas = Despesas::create([
                'descricao' => $request->descricao,
                'valor' => $request->valor,
                'data' => $request->data,
            ]);

            return $despesas;
        });
    }
}