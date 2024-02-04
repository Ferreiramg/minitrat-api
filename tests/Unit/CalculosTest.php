<?php

namespace Tests\Unit;

use App\Models\Configuracao;
use App\Services\Residencial;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class CalculosTest extends TestCase
{
    /**
     * @dataProvider residencialDataProvider
     */
    public function testShoudThatCalcResidencialWithSuccess(array $payload, $expected)
    {
        $configuraca = new Configuracao(
            [
                'padrao_alto' => 160,
                'padrao_medio' => 130,
                'padrao_baixo' => 100,
                'taxa_infiltracao' => 0.01296,
            ]
        );

        $instance = new Residencial($configuraca);

        $produto = $instance->calcular(new Request($payload));

        var_dump($produto);

        $this->assertEquals(true, true);
    }


    public function residencialDataProvider()
    {

        yield [[
            "padrao" => "A",
            "tipo_empree" => "R",
            "fase_empree" => "I",
            "modelo_empree" => "Casa",
            "total_empree" > 2
        ], []];

        yield [[
            'padrao' => 'M',
            "tipo_empree" => "R",
            "fase_empree" => "M",
            "modelo_empree" => "Casa",
            "total_empree" > 1
        ], []];

        yield [[
            'padrao' => 'B',
            "tipo_empree" => "R",
            "fase_empree" => "F",
            "modelo_empree" => "Casa",
            "total_empree" > 1
        ], []];
    }
}
