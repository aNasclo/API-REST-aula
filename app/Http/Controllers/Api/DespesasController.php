<?php

namespace App\Http\Controllers\Api;

use App\Models\Despesas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DespesasRepository;
use App\Http\Requests\DespesasFormRequest;
use App\Models\Categorias;

class Despesascontroller extends Controller
{

    public function __construct(private DespesasRepository $despesasRepository) {}
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Despesas::query();
        if ($request->has('descricao')) {
            $query->where('descricao', $request->descricao);
        }

        return $query->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DespesasFormRequest $request)
    {
        return response()->json($this->despesasRepository->add($request), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $despesas)
    {
        return Despesas::whereId($despesas)->with('categorias')->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DespesasFormRequest $request, int $despesas)
    {
        $despesa = Despesas::find($despesas);
        $despesa->fill($request->all());
        $despesa->save();
    }

    /**
     * Remove the specified resource from storage.
     */
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
