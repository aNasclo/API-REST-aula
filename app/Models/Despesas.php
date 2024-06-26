<?php

namespace App\Models;

use App\Models\Categorias;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Despesas extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'valor', 'data'];

    public function categorias()
    {
        return $this->hasOne(Categorias::class, 'despesas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
