<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Produto;
use App\Services\Comercial;
use App\Services\Industrial;
use App\Services\Residencial;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    public function index(Produto $produto)
    {
        return view('produtos.index', ['produtos' => $produto->get()]);
    }

    public function store(Request $request, Produto $produto)
    {

        if ($request->id) {
            $produto = $produto->find($request->id);
            $produto->update($request->all());
        } else {
            $produto->create($request->all());
        }

        return redirect('/produtos');
    }

    public function calculo(Request $request, Configuracao $configuracao)
    {
        try {

            $conf = $configuracao->first();

            $factory = match ($request->tipo_empree) {
                'R' => new Residencial($conf),
                'C' => new Comercial($conf),
                'I' => new Industrial($conf)
            };

            $produto =/* Produto */ $factory->calcular($request);

            //email dispara aqui

            return response()->json($produto);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 404);
        }
    }
}
