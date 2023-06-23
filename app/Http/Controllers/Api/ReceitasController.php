<?php

namespace App\Http\Controllers\Api;

use App\Models\Receitas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ReceitasRepository;
use App\Http\Requests\ReceitasFormRequest;

class ReceitasController extends Controller
{
    public function __construct(private ReceitasRepository $receitasRepository) {}
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $query = Receitas::query();
        // if ($request->has('descricao')) {
        //     $query->whereDescricao($request->descricao);
        // }

        // return $query->paginate(5);

        $receitas = Receitas::all();

        return response()->json($receitas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReceitasFormRequest $request)
    {
        return response()->json($this->receitasRepository->add($request), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $receitas)
    {
        return Receitas::find($receitas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReceitasFormRequest $request, int $receitas)
    {
        $receita = Receitas::find($receitas);
        $receita->fill($request->all());
        $receita->save();
    }

    /**
     * Remove the specified resource from storage.
     */
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
