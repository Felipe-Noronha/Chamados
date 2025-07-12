<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome_cliente',
        'email_cliente',
        'assunto',
        'mensagem',
        'status',
        'prioridade',
        'secret_token'
    ];
}