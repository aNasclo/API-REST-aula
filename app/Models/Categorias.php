<?php

namespace App\Models;

use App\Models\Despesas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorias extends Model
{
    use HasFactory;

    protected $fillable = ["categoria"];

    public function __construct()
    {
        $this->outras();
    }

    public function despesas()
    {
        return $this->hasMany(Despesas::class, 'categoria_id');
    }

    public function alimentacao()
    {
        $this->categoria = 'Alimentação';
    }

    public function saude()
    {
        $this->categoria = 'Saúde';
    }

    public function moradia()
    {
        $this->categoriai = 'Moradia';
    }

    public function transporte()
    {
        $this->categoria = 'Transporte';
    }

    public function educacao()
    {
        $this->categoria = 'Educação';
    }

    public function lazer()
    {
        $this->categoria = 'Lazer';
    }

    public function imprevistos()
    {
        $this->categoria = 'Imprevistos';
    }

    public function outras()
    {
        $this->categoria = 'Outras';
    }
}
