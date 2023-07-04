<?php

namespace App\Repositories;

use App\Models\Despesas;
use App\Models\Categorias;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DespesasFormRequest;
use Illuminate\Validation\ValidationException;

class EloquentDespesasRepository implements DespesasRepository
{
    public function add(DespesasFormRequest $request): Despesas
    {

        $validator = Validator::make($request->all(), $request->rules(), $request->messages());

        if ($validator->fails()) {
            throw new ValidationException($validator);
            // Ou você pode retornar uma mensagem de erro em vez de lançar uma exceção
            // return response()->json(['error' => $validator->errors()], 422);
        }

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