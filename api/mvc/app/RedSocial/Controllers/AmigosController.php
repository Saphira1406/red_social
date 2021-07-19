<?php

namespace RedSocial\Controllers;

// use RedSocial\Core\App;
use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Amigo;

class AmigosController extends Controller
{
    public function listado()
    {
        $this->requiresAuth();
        $id = Route::getUrlParameters()['id'];
        $amigos = (new Amigo())->traerTodos($id);
        View::renderJson($amigos);
    }
}
