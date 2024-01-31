<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;

class SolicitacaoController extends Controller
{

    public function index()
    {
        $solicitacoes = Solicitacao::whereNotNull('nome')->get();
        
        return view('solicitacao.index', compact('solicitacoes'));
    }

}
