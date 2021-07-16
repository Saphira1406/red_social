<?php

namespace RedSocial\Controllers;

use RedSocial\Auth\Auth;
use RedSocial\Models\Usuario;
use RedSocial\Validation\Validator;

class AuthController
{
    public function loginProcesar()
    {
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        $validator = new Validator($postData, [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (!$validator->passes()) {
            $errores =  $validator->getErrores();
            $texto = '';
            foreach ($errores as $error => $val) {
                $texto .= "$val[0] ";
            };
            echo json_encode([
                "success" => false,
                "msg" => $texto
            ]);
            exit;
        }

        $email = trim($postData['email']);
        $password = $postData['password'];

        $auth = new Auth;

        if ($auth->login($email, $password)) {

            $usuario = new Usuario();
            $usuario = $usuario->getByEmail($email);

            if ($usuario) {
                (new Auth)->setAsAuthenticated($usuario);
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
            'msg' => 'Los datos ingresados no coinciden con nuestros registros.',
        ]);
    }

    public function logout()
    {
        (new Auth)->logout();
        echo json_encode([
            'success' => true,
        ]);
    }

    public function options()
    {
    }
}
