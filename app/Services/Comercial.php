<?php

namespace App\Services;

use App\Models\Produto;
use Illuminate\Http\Request;

class Comercial extends AbstractCalculos
{

    /**
     * @see AbstractCalculos::calcular()
     */
    public function calcular(Request $request): Produto
    {

        $turnos = [
            json_decode($request->turno_um, true),
            json_decode($request->turno_dois, true),
            json_decode($request->turno_tres, true)
        ];

        $vazoes = [];
        foreach ($turnos as $turno) {
            if ((int)$turno['numero_funcionarios'] > 0) {

                $hi = (int)$turno['abertura_horas'];

                $hf = (int)$turno['fecha_horas'];

                $vazoes['vazao_diaria_resultado'][] = $vazao_diaria_resultado = $turno['numero_funcionarios'] * $this->getFuncionarioAdmin() + $turno['numero_refeicoes'] * $this->getRefeicao() + $turno['numero_visitantes'] * $this->getVisita();

                $vazoes['vazao_horaria_resultado'][] = $vazao_diaria_resultado / abs($hf - $hi);
            }
        }

        $capacidade_resultado = array_sum($vazoes['vazao_diaria_resultado']) / 1000;

        $capacidade_media_resultado = max($vazoes['vazao_horaria_resultado']) / 1000;

        $produto = Produto::where('vazao_diaria', '>=', round($capacidade_resultado, 2))->orderBy('vazao_diaria', 'ASC')->first();

        if ($produto !== null) {
            $produto_medio =  Produto::where('vazao_diaria', $produto->vazao_diaria)->where('vazao_horaria_media', '>=', round($capacidade_media_resultado, 2))->first();

            if ($produto_medio !== null) {
                return $produto_medio;
            }

            return Produto::where('vazao_diaria', $produto->vazao_diaria)->where('vazao_diaria', Produto::where('vazao_diaria', $produto->vazao_diaria)->max('vazao_horaria_media'))->first();
        }

        return  Produto::where('vazao_diaria', Produto::max('vazao_diaria'))->first();
    }
}
