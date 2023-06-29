<?php

namespace App\Http\Controllers\Api;

use App\Models\Despesas;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

trait DuplicadoTrait
{
    public function duplicado(FormRequest $request, Model $model)
    {
        $requestDescricao = $request->descricao;
        $requestData = explode('/', $request->data);

        $objeto = $model::where('descricao', $requestDescricao)->first();
    
        if ($objeto && $objeto->data) {
        $dataDB = explode('/', $objeto->data);

        if ($dataDB[1] == $requestData[1]) {
            return true;
        }
    }

    return false;
    }
}