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
    
    public function index(Request $request)
    {
        $query = Receitas::query();
        if ($request->has('descricao')) {
            $query->whereDescricao($request->descricao);
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
