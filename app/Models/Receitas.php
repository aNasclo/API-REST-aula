<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receitas extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'valor', 'data'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
