<?php

namespace App\Services;


use App\Models\Produto;
use Illuminate\Http\Request;

class Residencial extends AbstractCalculos
{

    const EXT_REDE_COLETORA_RESIDENCIAL = 8;
    const EXT_REDE_COLETORA_LOTEAMENTO = 8;
    const EXT_REDE_COLETORA_APARTAMENTO = 0;

    const PERIODO_GERACAO = 24;
    const NUMERO_PESSOAS = 4;

    const EXTESAO_REDE_COLETORA = [
        'Casa' => self::EXT_REDE_COLETORA_RESIDENCIAL,
        'Lote' => self::EXT_REDE_COLETORA_LOTEAMENTO,
        'Apartamento' => self::EXT_REDE_COLETORA_APARTAMENTO
    ];

    /**
     * @see AbstractCalculos::calcular()
     */
    public function calcular(Request $request): Produto
    {

        $total_empreendimento = (int)$request->total_empree;

        $vazao_infiltracao = $this->getTaxaInfiltracao() *  $total_empreendimento  * self::EXTESAO_REDE_COLETORA[$request->modelo_empree];

        $padrao = match ($request->padrao) {
            'A' => $this->getPadraoAlto(),
            'M' => $this->getPadraoMedio(),
            'B' => $this->getPadraoBaixo(),
        };

        $vazao_diaria_resultado     =  $total_empreendimento  * self::NUMERO_PESSOAS *  $padrao + $vazao_infiltracao;

        $vazao_media_resultado      = $vazao_diaria_resultado / self::PERIODO_GERACAO;

        $vazao_diaria_resultado     = $vazao_diaria_resultado / 1000;

        $vazao_media_resultado      = $vazao_media_resultado / 1000;

        $produto = Produto::where('vazao_diaria', '>=', round($vazao_diaria_resultado, 2))->orderBy('vazao_diaria', 'ASC')->first();

        if ($produto !== null) {
            $produto_medio =  Produto::where('vazao_diaria', $produto->vazao_diaria)->where('vazao_horaria_media', '>=', round($vazao_media_resultado, 2))->first();

            if ($produto_medio !== null) {
                return $produto_medio;
            }

            return Produto::where('vazao_diaria', $produto->vazao_diaria)->where('vazao_diaria', Produto::where('vazao_diaria', $produto->vazao_diaria)->max('vazao_horaria_media'))->first();
        }

        return  Produto::where('vazao_diaria', Produto::max('vazao_diaria'))->first();
    }
}
