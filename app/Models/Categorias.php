<?php

namespace App\Models;

use App\Models\Despesas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorias extends Model
{
    use HasFactory;

    protected $fillable = ["categorias"];

    // public function __construct()
    // {
    //     $this->outras();
    // }

    public function despesas()
    {
        return $this->hasMany(Despesas::class, 'categorias_id');
    }

    // public function alimentacao()
    // {
    //     $this->categorias = 'Alimentação';
    // }

    // public function saude()
    // {
    //     $this->categorias = 'Saúde';
    // }

    // public function moradia()
    // {
    //     $this->categoriai = 'Moradia';
    // }

    // public function transporte()
    // {
    //     $this->categorias = 'Transporte';
    // }

    // public function educacao()
    // {
    //     $this->categorias = 'Educação';
    // }

    // public function lazer()
    // {
    //     $this->categorias = 'Lazer';
    // }

    // public function imprevistos()
    // {
    //     $this->categorias = 'Imprevistos';
    // }

    // public function outras()
    // {
    //     $this->categorias = 'Outras';
    // }
}
