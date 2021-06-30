<?php

namespace RedSocial\Controllers;

use RedSocial\Auth\Auth;
use RedSocial\Models\Usuario;

use RedSocial\Core\App;
use RedSocial\Core\View;
use RedSocial\Validation\Validator;

require_once __DIR__ . '../../../../../functions/auth.php';

class AuthController
{
    /*
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
*/
    public function loginProcesar()
    {
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        /*
        $validator = new Validator($postData, [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (!$validator->passes()) {
            $_SESSION['errores'] = $validator->getErrores();
            $_SESSION['old_data'] = $postData;
            // App::redirect('iniciar-sesion');
        }
*/
        $email = trim($postData['email']);
        $password = $postData['password'];

        $auth = new Auth;

        if ($auth->login($email, $password)) {

            $usuario = new Usuario();
            $usuario = $usuario->getByEmail($email);

            if ($usuario) {
                (new Auth)->setAsAuthenticated($usuario);
                //     $_SESSION['id'] = $usuario->getId();
                echo json_encode([
                    'success' => true,
                    'data' => [
                        'id' => $usuario->getId(),
                        'usuario' => $usuario->getUsuario(),
                        'imagen' => $usuario->getImagen(),
                        'nombre' => $usuario->getNombre(),
                        'apellido' => $usuario->getApellido(),
                        'email' => $email,
                    ]
                ]);
                exit;
            }
        }
        echo json_encode([
            'success' => false,
            'msg' => 'Ocurrió un error al tratar de loguearse.',
        ]);
    }

    public function logout()
    {
        //        $auth = new Auth;
        //        $auth->logout();
        (new Auth)->logout();
        // $_SESSION['status_success'] = 'Cerraste sesión con éxito. ¡Te esperamos pronto!';
        // App::redirect('iniciar-sesion');
        echo json_encode([
            'success' => true,
        ]);
    }
}
