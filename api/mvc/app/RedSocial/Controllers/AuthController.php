<?php

namespace RedSocial\Controllers;

use RedSocial\Auth\Auth;
use RedSocial\Models\Usuario;
use RedSocial\Validation\Validator;
use RedSocial\Validation\EmptyFieldsException;
use RedSocial\Validation\NotExistentRuleException;
use RedSocial\DB\QueryException;
use RedSocial\Debug\Debug;

class AuthController
{
    public function loginProcesar()
    {
        try {
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
        } catch (NotExistentRuleException $e) {
            echo json_encode([
                'success' => false,
                'msg' => 'No existe una validación llamada: ' . $e->getRuleName(),
            ]);
        } catch (EmptyFieldsException $e) {
            echo json_encode([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        } catch (QueryException $e) {
            $debugLog = Debug::printQueryException($e);

            $result = [
                'success' => false,
                'msg' => 'Ocurrió un error inesperado y no se pudo completar la acción.',
            ];

            if ($debugLog != null) {
                $result['debugLog'] = $debugLog;
            }

            echo json_encode($result);
        }
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
