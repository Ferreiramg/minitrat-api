<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'vazao_diaria', 'vazao_horaria_media'];

    const TIPO_EMP = [
        'R' => 'Residêncial',
        'C' => 'Comercial',
        'I' => 'Industrial',
    ];

    const FASE_EMP = [
        'I' => 'Inicial',
        'M' => 'Intermediária',
        'F' => 'Final',
    ];

    const PADRAO_EMP = [
        'A' => 'Alto',
        'M' => 'Médio',
        'B' => 'Baixo',
    ];
    
}
