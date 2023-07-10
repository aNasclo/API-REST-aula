<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Receitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ReceitasFormRequest;
use Illuminate\Validation\ValidationException;

class EloquentReceitasRepository implements ReceitasRepository
{
    public function add(ReceitasFormRequest $request, User $user): Receitas
    {

        $validator = Validator::make($request->all(), $request->rules(), $request->messages());

        if ($validator->fails()) {
            throw new ValidationException($validator);
            // Ou você pode retornar uma mensagem de erro em vez de lançar uma exceção
            // return response()->json(['error' => $validator->errors()], 422);
        }
        
        return DB::transaction(function () use ($request, $user) {
            $receitas = $user->receitas()->create([
                'descricao' => $request->descricao,
                'valor' => $request->valor,
                'data' => $request->data,
            ]);

            return $receitas;
        });
    }
}