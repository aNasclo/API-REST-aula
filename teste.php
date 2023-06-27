<?php

use App\Models\Categorias;

require "vendor/autoload.php";

// use App\Models\Categorias;

$objeto = new Categorias();

$objeto->saude();

echo $objeto->categoria;