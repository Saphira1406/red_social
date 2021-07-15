<?php

namespace RedSocial\Controllers;

use RedSocial\Auth\Auth;

class Controller
{
    /** @var Auth */
    protected $auth;

    public function __construct()
    {
        $this->auth = new Auth;
    }

    /**
     * Verifica que el usuario esté autenticado.
     */
    protected function requiresAuth()
    {
        if (!$this->auth->isAuthenticated()) {
            echo json_encode([
                'success' => false,
                'msg' => 'Se requiere iniciar sesión para realizar esta acción.'
            ]);
        }
    }
}
