<?php

namespace App\Services;

use App\Models\Configuracao;
use App\Models\Produto;
use Illuminate\Http\Request;

abstract class AbstractCalculos
{

    protected Configuracao $configuracao;

    public function __construct(Configuracao $configuracao)
    {
        $this->configuracao = $configuracao;
    }

    /**
     * Calcula e encotrata o produto cadastrado
     * @param Request $request
     * @return Produto
     */
    abstract public function calcular(Request $request): Produto;

    public function getPadraoAlto()
    {
        return $this->configuracao->padrao_alto;
    }

    public function getPadraoMedio()
    {
        return $this->configuracao->padrao_medio;
    }

    public function getPadraoBaixo()
    {
        return $this->configuracao->padrao_baixo;
    }

    public function getFuncionarioOperacao()
    {
        return $this->configuracao->funcionario_operacao;
    }

    public function getFuncionarioAdmin()
    {
        return $this->configuracao->funcionario_admin;
    }

    public function getRefeicao()
    {
        return $this->configuracao->refeicao;
    }

    public function getVisita()
    {
        return $this->configuracao->visita;
    }

    public function getTaxaInfiltracao()
    {
        return $this->configuracao->taxa_infiltracao;
    }

    /**
     * Extrai os dados do json e normaliza os dados
     * @param string $data
     * @return array
     */
    protected function extractJson(string $dados): array
    {
        $json = json_decode($dados, true);
        $data = [];

        if (!is_array($json)) return [htmlspecialchars($dados)];

        if (isset($json['numero_funcionarios']) && empty($json['numero_funcionarios'])) return ["Sem Informações"];

        if (isset($json['abertura_horas'])) {
            $json['abertura_horas'] = $json['abertura_horas'] . ':' . $json['abertura_minutos'];
            unset($json['abertura_minutos']);
        }

        if (isset($json['fecha_horas'])) {
            $json['fecha_horas'] = $json['fecha_horas'] . ':' . $json['fecha_minutos'];
            unset($json['fecha_minutos']);
        }

        $data = [];

        ksort($json);

        foreach ($json as $chave => $valor) {
            $data[$chave] = $valor;
        }


        return $data;
    }
}
