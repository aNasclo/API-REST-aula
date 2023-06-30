<?php

namespace App\Http\Controllers\Api;

use App\Models\Receitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ReceitasRepository;
use App\Http\Requests\ReceitasFormRequest;
use App\Http\Controllers\Api\DuplicadoTrait;

class ReceitasController extends Controller
{
    use DuplicadoTrait;
    
    public function __construct(private ReceitasRepository $receitasRepository) {}
    
    public function listByMonth($ano, $mes)
    {
        $receitas = Receitas::where('data', 'LIKE', "%/{$mes}/{$ano}%")
            ->get(['descricao', 'valor', 'data']);
            
        return response()->json($receitas);
    }

    public function index(Request $request)
    {
        $query = Receitas::query();
        // NESSE AQUI FAZ A BUSCA EXATA DO QUE É COLOCADO NA URL

        // if ($request->has('descricao')) {
        //     $query->whereDescricao($request->descricao);
        // }

        // FAZ A BUSCA BUCANDO ITENS SEMELHANTES AO QUE FOI POSTO NA URL
        if ($request->has('descricao')) {
            $descricao = $request->descricao;
            $query->where('descricao', 'LIKE', '%' . $descricao . '%');
        }

        return $query->paginate(8);
    }

    public function store(ReceitasFormRequest $request)
    {
        $model = new Receitas();
        $result = $this->duplicado($request, $model);

        if($result) {
            return response()->json(['error' => 'Já existe uma RECEITA com esse nome este MES.'], 400);
        }

        return response()->json($this->receitasRepository->add($request), 201);
    }

    public function show(int $receitas)
    {
        return Receitas::find($receitas);
    }

    public function update(ReceitasFormRequest $request, int $receitas)
    {
        $model = new Receitas();
        $result = $this->duplicado($request, $model);

        if($result) {
            return response()->json(['error' => 'Já existe uma RECEITA com esse nome este MES.'], 400);
        }

        $receita = Receitas::find($receitas);
        $receita->fill($request->all());
        $receita->save();
    }

    public function destroy(string $ids)
    {
        $ids = request()->query('ids');
        $idsArray = explode(',', $ids);

        foreach ($idsArray as $id) {
            Receitas::destroy($id);
        }
        
        return response()->noContent();
    }
}
