<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Http\Request;


class ConfiguracaoController extends Controller
{

    public function index(Configuracao $configuracao)
    {
        return view(
            'configuracao.index',
            [
                'configuracao' => $configuracao->get()->map(function ($item) {
                    $item->pdf = asset('storage/' . $item->pdf);
                    return $item;
                })
            ]
        );
    }

    public function store(Request $request, Configuracao $configuracao)
    {

        if (!$request->hasFile('file') && !$request->id) {
            return redirect('/configuracoes')->withErrors('É necessário enviar um arquivo PDF');
        }

        $file = $request->file->store('pdfs','public');

        $request->query('pdf', $file);

        $request->request->add(['pdf' => $file]);

        if ($request->id) {
            $configuracao = $configuracao->find($request->id);
            $configuracao->update($request->all());
        } else {
            $configuracao->create($request->all());
        }

        return redirect('/configuracoes');
    }
}
