<?php

use App\Models\Configuracao;

abstract class AbstractCalculos
{

    protected $configuracao;

    public function __construct(Configuracao $configuracao)
    {
        $this->configuracao = $configuracao;
    }

    abstract public function calcular(float $vazaoDiaria, float $vazaoHorariaMedia);

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
}
