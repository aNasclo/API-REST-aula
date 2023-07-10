<?php

namespace App\Http\Controllers\Api;

use App\Models\Receitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ReceitasRepository;
use App\Http\Requests\ReceitasFormRequest;
use App\Http\Controllers\Api\DuplicadoTrait;
use App\Http\Controllers\Api\UserAutenticadoTrait;

class ReceitasController extends Controller
{
    use DuplicadoTrait;
    use UserAutenticadoTrait;
    
    public function __construct(private ReceitasRepository $receitasRepository) {}
    
    public function listByMonth($ano, $mes)
    {
        $user = $this->autenticado();

        $receitas = Receitas::where('data', 'LIKE', "%/{$mes}/{$ano}%")
            ->where('user_id', $user->id)
            ->get(['descricao', 'valor', 'data']);
            
        return response()->json($receitas);
    }

    public function index(Request $request)
    {
        $user = $this->autenticado();

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

        $query->where('user_id', $user->id);

        return $query->paginate(8);
    }

    public function store(ReceitasFormRequest $request)
    {
        $user = $this->autenticado();

        $model = new Receitas();
        $result = $this->duplicado($request, $model);

        if($result) {
            return response()->json(['error' => 'Já existe uma RECEITA com esse nome este MES.'], 400);
        }

        return response()->json($this->receitasRepository->add($request, $user), 201);
    }

    public function show(int $receitas)
    {
        $user = $this->autenticado();

        return Receitas::whereId($receitas)->where('user_id', $user->id)->first();
    }

    public function update(ReceitasFormRequest $request, int $receitas)
    {
        $user = $this->autenticado();

        $model = new Receitas();
        $result = $this->duplicado($request, $model);

        if($result) {
            return response()->json(['error' => 'Já existe uma RECEITA com esse nome este MES.'], 400);
        }

        $receita = Receitas::where('id', $receitas)->where('user_id', $user->id)->first();

        if (!$receita) {
            return response()->json(['error' => 'Receita não encontrada. Confira o ID passado :)'], 404);
        }

        $receita->fill($request->all());
        $receita->save();
    }

    public function destroy(string $ids)
    {
        $user = $this->autenticado();

        $ids = request()->query('ids');
        $idsArray = explode(',', $ids);

        foreach ($idsArray as $id) {
            $receitas = Receitas::where('id', $id)->where('user_id', $user->id)->first();

            if ($receitas) {
                $receitas->delete();
            }
        }
        
        return response()->noContent();
    }
}
