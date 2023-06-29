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
        $requestData = explode('/', $request->data); // Aqui é onde separo Dia/Mes/Ano do que vem no formulario

        $objetos = $model::where('descricao', $requestDescricao)->get();

        foreach ($objetos as $objeto) {
            $dataDB = explode('/', $objeto->data); // Aqui é onde separo Dia/Mes/Ano do que tem no DB
            if ($dataDB[1] == $requestData[1] && $dataDB[2] == $requestData[2]) {
                return true;
            }
        }

    return false;
    }
}