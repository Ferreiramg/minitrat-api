<?php

namespace App\Http\Controllers;

use App\Mail\NotifyGerentes;
use App\Mail\NotifySolicitante;
use App\Models\Configuracao;
use App\Models\Produto;
use App\Models\Solicitacao;
use App\Services\Comercial;
use App\Services\Industrial;
use App\Services\Residencial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use stdClass;

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

        return redirect(route('produtos'));
    }

    public function calculo(Request $request, Configuracao $configuracao)
    {
        try {

            $conf = $configuracao->first();

            $factory = match ($request->tipo_empree) {
                'R' => new Residencial($conf),
                'C' => new Comercial($conf),
                'I' => new Industrial($conf)
            };

            $produto =/* Produto */ $factory->calcular($request);

            $solicitacao = Solicitacao::find($request->id);

            $solicitacao->update([
                'produto_nome' => $produto->nome,
                'produto_vaza_diaria' => $produto->vazao_diaria,
                'produto_vaza_horaria_media' => $produto->vazao_horaria_media,
                'produto_quantidade' => 1, //TODO: fazer o calculo da quantidade
            ]);

            $anexo = $conf->pdf ? public_path('storage/' . $conf->pdf) : null;

            $dados = new stdClass();

            $dados->html = $this->renderMail($solicitacao, $produto);

            Mail::to([$solicitacao->email])->send(new NotifySolicitante($anexo));

            Mail::to(["fernando@mintrat.com.br", "joao@mintrat.com.br"])->send(new NotifyGerentes($dados));

            return response()->json($produto);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 404);
        }
    }

    private function renderMail(Solicitacao $solicitacao, Produto $produto)
    {

        $map_keys = [
            'tipo_empree' => 'Tipo de empreendimento',
            'fase_empree' => 'Fase do empreendimento',
            'padrao' => 'Padrão',
            'modelo_empree' => 'Modelo de empreendimento',
            'total_empree' => 'Total de empreendimentos',
            'distancia_ponto' => 'Comprimento Total da Rede Coletora (m)',
            'turno_um' => 'Turno 1',
            'turno_dois' => 'Turno 2',
            'turno_tres' => 'Turno 3',
            'op_turno_um' => 'Turno 1 Operacional',
            'op_turno_dois' => 'Turno 2 Operacional',
            'op_turno_tres' => 'Turno 3 Operacional',
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'email' => 'E-mail',
            'uf' => 'UF',
            'cidade' => 'Cidade',
            'receber_notificacao' => 'Receber notificação',
            'created_at' => 'Data de envio',
        ];

        $map_keys_json = [
            'setor' => 'Setor',
            'hora_fim' => 'Fim do turno',
            'hora_inicio' => 'Início do turno',
            'numero_refeicoes' => 'Número de refeições',
            'numero_funcionarios' => 'Número de funcionários',
            'abertura_horas' => 'Abre às',
            'fecha_horas' => 'Fecha às',
            'numero_visitantes' => 'Número de visitantes',

        ];

        $map_empree = [
            'R' => 'Residencial',
            'C' => 'Comercial',
            'I' => 'Industrial',
        ];

        $map_fase_empree = [
            'I' => 'Inicial',
            'M' => 'Intermediária',
            'F' => 'Final',
        ];

        $map_padrao = [
            'A' => 'Alto',
            'M' => 'Médio',
            'B' => 'Baixo',
        ];

        function extractJson($data, $map_keys_json)
        {
            $json = json_decode($data, true);

            if (!is_array($json)) return htmlspecialchars($data);

            if (isset($json['numero_funcionarios']) && empty($json['numero_funcionarios'])) return "Sem Informações";

            if (isset($json['abertura_horas'])) {
                $json['abertura_horas'] = $json['abertura_horas'] . ':' . $json['abertura_minutos'];
                unset($json['abertura_minutos']);
            }

            if (isset($json['fecha_horas'])) {
                $json['fecha_horas'] = $json['fecha_horas'] . ':' . $json['fecha_minutos'];
                unset($json['fecha_minutos']);
            }

            $html = '<table>';

            ksort($json);

            foreach ($json as $chave => $valor) {
                $html .= '<tr>';
                $html .= '<td>' . ($map_keys_json[$chave] ?? $chave) . '</td>';
                $html .= '<td>' . $valor . '</td>';
                $html .= '</tr>';
            }

            $html .= '</table>';

            return $html;
        }

        $tabelaHTML = '<table>';

        foreach ($solicitacao->toArray() as $chave => $valor) {

            if (!empty($valor) && array_key_exists($chave, $map_keys)) {


                $valor = $chave == 'tipo_empree' ? $map_empree[$valor] : $valor;

                $valor = $chave == 'fase_empree' ? $map_fase_empree[$valor] : $valor;

                $valor = $chave == 'padrao' ? $map_padrao[$valor] : $valor;

                $tabelaHTML .= '<tr>';
                $tabelaHTML .= '<td>' . $map_keys[$chave] . '</td>';
                $tabelaHTML .= '<td>' . extractJson($valor, $map_keys_json) . '</td>';
                $tabelaHTML .= '</tr>';
            }
        }
        $tabelaHTML .= "<tr>
            <td>Produto</td>
            <td>{$produto->nome}</td>
        </tr>";

        $tabelaHTML .= '</table>';

        return $tabelaHTML;
    }
}
