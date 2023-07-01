<?php

namespace App\Http\Controllers;

use App\Models\Despesas;
use App\Models\Receitas;
use Illuminate\Http\Request;

class ResumoController extends Controller
{
    public function resumoDoMes(string $ano, string $mes) 
    {
        $despesas = Despesas::where('data', 'LIKE', "%/{$mes}/{$ano}%")
            ->get(['valor']);

        $totalDespesas = $despesas->sum('valor');

        $receitas = Receitas::where('data', 'LIKE', "%/{$mes}/{$ano}%")
            ->get(['valor']);

        $totalReceitas = $receitas->sum('valor');

        $saldoFinal = $totalReceitas - $totalDespesas;

         // ------------------------------------------------------------\\
        //                      Resumo por categoria                     \\

        $despesasPorCategoria = $this->resumoDoMesCategoria($ano, $mes);

        return response()->json(['Despesas' => $totalDespesas, 
                                'Receitas' => $totalReceitas, 
                                'Saldo Final' => $saldoFinal,
                                'Despesas por categoria' => $despesasPorCategoria]);
    }

    public function resumoDoMesCategoria(string $ano, string $mes) 
    {
        $despesas = Despesas::where('data', 'LIKE', "%/{$mes}/{$ano}%")
            ->with('categorias')
            ->get(['id','valor']);

        $despesasPorCategoria = $despesas->groupBy('categorias.categorias') // Pelo que eu entendi aqui ta pegando o with e em seguida o fillabble
        ->map(function ($group) {
            return [
                'total' => $group->sum('valor')
            ];
        });

        return $despesasPorCategoria;
    }
}
