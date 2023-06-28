<?php

namespace App\Models;

use App\Models\Despesas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorias extends Model
{
    use HasFactory;

    protected $fillable = ["categorias"];

    public function despesas()
    {
        return $this->belongsTo(Despesas::class);
    }
}
