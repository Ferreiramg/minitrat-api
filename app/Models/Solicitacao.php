<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    use HasFactory;

    public $table = 'wp_mi_solicitacoes';

    public $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id', 'tipo_empree', 'fase_empree', 'padrao', 'modelo_empree', 'total_empree', 'distancia_ponto', 'turno_um', 'turno_dois', 'turno_tres', 'op_turno_um', 'op_turno_dois', 'op_turno_tres', 'razao', 'nome', 'telefone', 'email', 'uf', 'cidade', 'receber_notificacao', 'created_at',
        'produto_nome', 'produto_vaza_diaria', 'produto_vaza_horaria_media', 'produto_quantidade'
    ];

    # Formata o tipo empreendimento para impressão na tela
    public function getTipoEmpreendimentoAttribute()
    {
        switch ($this->attributes['tipo_empree']) {
            case 'R':
                return 'Residêncial';
            case 'C':
                return 'Comercial';
            case 'I':
                return 'Industrial';
            default:
                return 'Não informado';
        }
    }

    public function getFaseEmpreendimentoAttribute()
    {
        switch ($this->attributes['fase_empree']) {
            case 'I':
                return 'Inicial';
            case 'M':
                return 'Intermediária';
            case 'F':
                return 'Final';
            default:
                return 'Não informado';
        }
    }
}
