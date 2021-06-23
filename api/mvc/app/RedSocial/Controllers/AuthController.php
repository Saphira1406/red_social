<?php

namespace RedSocial\Controllers;

use RedSocial\Auth\Auth;
use RedSocial\Core\App;
use RedSocial\Core\View;
use RedSocial\Validation\Validator;

class AuthController
{
    public function loginForm()
    {
        if (isset($_SESSION['old_data'])) {
            $oldData = $_SESSION['old_data'];
            unset($_SESSION['old_data']);
        } else {
            $oldData = [];
        }
        if (isset($_SESSION['errores'])) {
            $errores = $_SESSION['errores'];
            unset($_SESSION['errores']);
        } else {
            $errores = [];
        }
        if (isset($_SESSION['status_error'])) {
            $statusError = $_SESSION['status_error'];
            unset($_SESSION['status_error']);
        } else {
            $statusError = null;
        }

        View::render('auth/login', [
            'oldData' => $oldData,
            'errores' => $errores,
            'statusError' => $statusError,
        ]);
    }

    public function loginProcesar()
    {
        $validator = new Validator($_POST, [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (!$validator->passes()) {
            $_SESSION['errores'] = $validator->getErrores();
            $_SESSION['old_data'] = $_POST;
            // App::redirect('iniciar-sesion');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $auth = new Auth;

        if (!$auth->login($email, $password)) {
            //            $_SESSION['errores'] = [
            //                'db' => 'Las credenciales ingresadas no coinciden con nuestros registros.'
            //            ];
            $_SESSION['status_error'] = 'Las credenciales ingresadas no coinciden con nuestros registros.';
            $_SESSION['old_data'] = $_POST;
            // App::redirect('iniciar-sesion');
        }

        $_SESSION['status_success'] = '¡Bienvenido/a al sitio!';
        // App::redirect('productos');
    }

    public function logout()
    {
        //        $auth = new Auth;
        //        $auth->logout();
        (new Auth)->logout();
        $_SESSION['status_success'] = 'Cerraste sesión con éxito. ¡Te esperamos pronto!';
        // App::redirect('iniciar-sesion');
    }
}
