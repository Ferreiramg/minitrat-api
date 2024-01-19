<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;

    public $table = 'configuracoes';

    public $timestamps = false;

    protected $fillable = ['pdf', 'padrao_alto', 'padrao_medio', 'padrao_baixo', 'funcionario_operacao', 'funcionario_admin', 'refeicao', 'visita', 'taxa_infiltracao'];
}
