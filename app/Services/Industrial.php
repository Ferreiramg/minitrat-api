<?php

namespace App\Services;

use App\Models\Produto;
use DateTime;
use Illuminate\Http\Request;

class Industrial extends AbstractCalculos
{

    /**
     * @see AbstractCalculos::calcular()
     */
    public function calcular(Request $request): Produto
    {

        $turnos = [
            json_decode($request->turno_um, true),
            json_decode($request->turno_dois, true),
            json_decode($request->turno_tres, true),
            json_decode($request->op_turno_um, true),
            json_decode($request->op_turno_dois, true),
            json_decode($request->op_turno_tres, true)
        ];

        $taxa_infiltracao = ($this->getTaxaInfiltracao() * (int)$request->distancia_ponto) / 100;

        $vazoes = [];
        foreach ($turnos as $turno) {
            if ((int)$turno['numero_funcionarios'] > 0) {

                $inicio = DateTime::createFromFormat('H:i', $turno['hora_inicio']);
                $fim = DateTime::createFromFormat('H:i', $turno['hora_fim']);

                if ($fim < $inicio) {
                    $fim->modify('+1 day');
                }

                $diferenca = $inicio->diff($fim);

                $multiplicador = $turno['setor'] === 'administrativo' ? $this->getFuncionarioAdmin() : $this->getFuncionarioOperacao();

                $vazoes['vazao_diaria_resultado'][] = $vazao_diaria_resultado = $turno['numero_funcionarios'] * $multiplicador + $turno['numero_refeicoes'] * $this->getRefeicao();

                $vazoes['vazao_horaria_resultado'][] = $vazao_diaria_resultado / $diferenca->h;
            }
        }

        //vazao diaria
        $capacidade_resultado = (array_sum($vazoes['vazao_diaria_resultado']) / 1000) + $taxa_infiltracao;

        //duplicados *count_values nao funciona com float 
        $valueCounts = array_count_values(array_map(fn ($v) => "{$v}", $vazoes['vazao_horaria_resultado']));

        $duplicados = [];

        foreach ($valueCounts as $value => $count) {
            if ($count > 1) {
                $duplicados[] = $value;
            }
        }


        if (!empty($duplicados) && array_sum($duplicados) > max($vazoes['vazao_horaria_resultado'])) {
            $capacidade_media_resultado = (array_sum($duplicados) / 1000) + $taxa_infiltracao;
        } else {
            $capacidade_media_resultado = (max($vazoes['vazao_horaria_resultado']) / 1000) + $taxa_infiltracao;
        }

        //vazao horaria media + infiltracao / 24
        //TODO: validar o calulco parece estar incorreto
        $capacidade_media_resultado =  ($capacidade_media_resultado + $taxa_infiltracao) / 24;

        $produto = Produto::where('vazao_diaria', '>=', round($capacidade_resultado, 2))->get();

        if ($produto !== null) {
            $produto_medio =   $produto->where('vazao_horaria_media', '>=', round($capacidade_media_resultado, 2))->first();

            if ($produto_medio !== null) {
                return $produto_medio;
            }

            return $produto->where('vazao_diaria', $produto->max('vazao_horaria_media'))->first();
        }

        return  Produto::where('vazao_diaria', Produto::max('vazao_diaria'))->first();
    }
}
