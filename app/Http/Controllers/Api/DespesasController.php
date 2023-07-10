<?php

namespace App\Http\Controllers\Api;

use App\Models\Despesas;
use App\Models\Categorias;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DespesasRepository;
use App\Http\Requests\DespesasFormRequest;
use App\Http\Controllers\Api\DuplicadoTrait;
use App\Http\Controllers\Api\UserAutenticadoTrait;

class Despesascontroller extends Controller
{
    use DuplicadoTrait;
    use UserAutenticadoTrait;

    public function __construct(private DespesasRepository $despesasRepository) {}

    public function listByMonth($ano, $mes)
    {
        $user = $this->autenticado();

        $despesas = Despesas::where('data', 'LIKE', "%/{$mes}/{$ano}%")
            ->where('user_id', $user->id)
            ->with('categorias')
            ->get(['id', 'descricao', 'valor', 'data']);

        return response()->json($despesas);
    }
    
    public function index(Request $request)
    {
        $user = $this->autenticado();

        $query = Despesas::query()->with('categorias');

        if ($request->has('descricao')) {
            $descricao = $request->descricao;
            $query->where('descricao', 'LIKE', '%' . $descricao . '%');
        }

        $query->where('user_id', $user->id);

        return $query->paginate(8);
    }

    public function store(DespesasFormRequest $request)
    {
        $user = $this->autenticado();

        $model = new Despesas();
        $result = $this->duplicado($request, $model);

        if($result) {
            return response()->json(['error' => 'Já existe uma DESPESA com esse nome este MES.'], 400);
        }

        return response()->json($this->despesasRepository->add($request, $user), 201);
    }

    public function show(int $despesas)
    {
        $user = $this->autenticado();

        return Despesas::whereId($despesas)->where('user_id', $user->id)->with('categorias')->first();
    }

    public function update(DespesasFormRequest $request, int $despesas)
    {
        $model = new Despesas();
        $result = $this->duplicado($request, $model);

        if($result) {
            return response()->json(['error' => 'Já existe uma DESPESA com esse nome este MES.'], 400);
        }

        $user = $this->autenticado();

        $despesa = Despesas::where('id', $despesas)->where('user_id', $user->id)->first();

        if (!$despesa) {
            return response()->json(['error' => 'Despesa não encontrada. Confira o ID passado :)'], 404);
        }

        $despesa->fill($request->all());
        $despesa->save();
    }

    public function destroy(string $ids)
    {
        $user = $this->autenticado();

        $ids = request()->query('ids');
        $idsArray = explode(',', $ids);

        foreach ($idsArray as $id) {
            $despesa = Despesas::where('id', $id)->where('user_id', $user->id)->first();

            if ($despesa) {
                $despesa->delete();
            }
        }
        
        return response()->noContent();
    }
}
