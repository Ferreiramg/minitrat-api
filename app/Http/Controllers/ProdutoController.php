<?php

namespace App\Http\Controllers;

use App\Models\Produto;
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
}
