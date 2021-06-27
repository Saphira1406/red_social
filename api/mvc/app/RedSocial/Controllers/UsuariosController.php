<?php

namespace RedSocial\Controllers;

use RedSocial\Auth\Auth;
use RedSocial\Core\App;
use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Usuario;
use RedSocial\Validation\Validator;

class UsuariosController extends Controller
{
    public function ver()
    {
        // Capturamos el parámetro de la URL que definidos en la ruta.
        //        $params = Route::getUrlParameters();
        //        $id = $params['id'];
        $id = Route::getUrlParameters()['id'];

        //        echo "El id que pidieron es: " . $id;
        $usuario = (new Usuario())->getByPk($id);

        //        View::render('usuarios/ver', compact('usuario'));
        View::renderJson($usuario);
    }

    public function nuevoGuardar()
    {
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        $nombre = $postData['nombre'];
        $apellido = $postData['apellido'];
        $email = $postData['email'];
        $password = $postData['password'];

        $data = [
            "nombre"  => $nombre,
            "apellido"  => $apellido,
            "email"    => $email,
            "password" => $password,
        ];

        $rules = [
            "email" => ["required"],
            "password" => ["required", "min:3"],
        ];

        $validator = new Validator($data, $rules);

        if ($validator->passes()) {
            $password = password_hash($postData['password'], PASSWORD_DEFAULT);
            $data['password'] = $password;
            $usuario_obj = new Usuario();
            $exito = $usuario_obj->crear($data);

            if ($exito) {
                echo json_encode([
                    'success' => true,
                    'msg' => 'El usuario se registró con éxito. Redireccionando...',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Ocurrió un error al tratar de registrar el usuario.',
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "msg" => $validator->getErrores()
            ]);
        }
    }

    /*
    public function eliminar()
    {
        $this->requiresAuth();

        $id = urlParam('id');
        $usuario = new Usuario();
        if(!$usuario->eliminar($id)) {
            $_SESSION['error'] = 'Ocurrió un error al tratar de guardar la información.';
         //   App::redirect('/usuarios');
            exit;
        }
        $_SESSION['exito'] = 'El usuario fue eliminado exitosamente.';
      //  App::redirect('/usuarios');
    }
    */
}
