<?php

namespace App\Repositories;

use App\Models\Despesas;
use App\Models\Categorias;
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

            $categoria = [
                'despesas_id' => $despesas->id,
                'categorias' => 'Outras',
            ];
            
            if ($request->categorias !== null) {
                $categoria = [
                    'despesas_id' => $despesas->id,
                    'categorias' => $request->categorias,
                ];
            }

            Categorias::insert($categoria);

            return $despesas;
        });
    }
}