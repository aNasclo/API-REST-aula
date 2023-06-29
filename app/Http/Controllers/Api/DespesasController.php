<?php

namespace App\Http\Controllers\Api;

use App\Models\Despesas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DespesasRepository;
use App\Http\Requests\DespesasFormRequest;
use App\Http\Controllers\Api\DuplicadoTrait;

class Despesascontroller extends Controller
{
    use DuplicadoTrait;

    public function __construct(private DespesasRepository $despesasRepository) {}
    
    public function index(Request $request)
    {
        $query = Despesas::query();
        if ($request->has('descricao')) {
            $query->where('descricao', $request->descricao);
        }

        return $query->paginate(5);
    }

    public function store(DespesasFormRequest $request)
    {
        $model = new Despesas();
        $result = $this->duplicado($request, $model);

        if($result) {
            return response()->json(['error' => 'Já existe uma DESPESA com esse nome este MES.'], 400);
        }

        return response()->json($this->despesasRepository->add($request), 201);
    }

    public function show(int $despesas)
    {
        return Despesas::whereId($despesas)->with('categorias')->first();
    }

    public function update(DespesasFormRequest $request, int $despesas)
    {
        $model = new Despesas();
        $result = $this->duplicado($request, $model);

        if($result) {
            return response()->json(['error' => 'Já existe uma DESPESA com esse nome este MES.'], 400);
        }
        
        $despesa = Despesas::find($despesas);
        $despesa->fill($request->all());
        $despesa->save();
    }

    public function destroy(string $ids)
    {
        $ids = request()->query('ids');
        $idsArray = explode(',', $ids);

        foreach ($idsArray as $id) {
            Despesas::destroy($id);
        }
        
        return response()->noContent();
    }
}
