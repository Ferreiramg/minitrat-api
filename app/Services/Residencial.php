<?php

namespace App\Services;


use App\Models\Produto;
use Illuminate\Http\Request;

class Residencial extends AbstractCalculos
{

    /**
     * @see AbstractCalculos::calcular()
     */
    public function calcular(Request $request): Produto
    {

        /**
         * Acessando parametros
         * Ex: $this->getPadraoAlto() * $this->getFuncionarioAdmin() + $request->funcionario_admin
         */
        return Produto::find(1);
    }
}
