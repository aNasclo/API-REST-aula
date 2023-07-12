<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

Trait UserAutenticadoTrait
{
    public function autenticado(): User
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado.'], 401);
        }

        return $user;
    }
}