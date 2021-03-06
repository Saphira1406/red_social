<?php

namespace RedSocial\Controllers;

use RedSocial\Core\App;
use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Usuario;
use RedSocial\Validation\Validator;
use RedSocial\Validation\EmptyFieldsException;
use RedSocial\Validation\NotExistentRuleException;
use RedSocial\Storage\FileUpload;
use RedSocial\Storage\InvalidFileTypeException;
use Exception;
use RedSocial\DB\QueryException;
use RedSocial\Debug\Debug;

class UsuariosController extends Controller
{
    public function ver()
    {
        $id = Route::getUrlParameters()['id'];
        $usuario = (new Usuario())->traerPorPK($id);
        View::renderJson($usuario);
    }

    public function nuevoGuardar()
    {
        try {

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
                "nombre" => ["required"],
                "apellido" => ["required"],
                "email" => ["required", "min:3"],
                "password" => ["required", "min:3"],
            ];

            $validator = new Validator($data, $rules);

            if ($validator->passes()) {
                $password = password_hash($postData['password'], PASSWORD_DEFAULT);
                $data['password'] = $password;
                $usuario_obj = new Usuario();

                if ($usuario_obj->verSiExiste($email)) {
                    echo json_encode([
                        'success' => false,
                        'msg' => 'El email ya se encuentra registrado.',
                    ]);
                    exit;
                }

                $exito = $usuario_obj->crear($data);

                if ($exito) {
                    echo json_encode([
                        'success' => true,
                        'msg' => 'El usuario se registr?? con ??xito.',
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'msg' => 'Ocurri?? un error al tratar de registrar el usuario.',
                    ]);
                }
            } else {
                $errores =  $validator->getErrores();
                $texto = '';
                foreach ($errores as $error => $val) {
                    $texto .= "$val[0] ";
                };
                echo json_encode([
                    "success" => false,
                    "msg" => $texto
                ]);
            }
        } catch (InvalidFileTypeException $e) {
            echo json_encode([
                'success' => false,
                'msg' => 'El formato del archivo no es correcto, se recibi??: ' . $e->getFileType(),
            ]);
        } catch (NotExistentRuleException $e) {
            echo json_encode([
                'success' => false,
                'msg' => 'No existe una validaci??n llamada: ' . $e->getRuleName(),
            ]);
        } catch (EmptyFieldsException $e) {
            echo json_encode([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function editarUsuario()
    {
        $this->requiresAuth();

        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        $id = urlParam('id');
        $usuario = $postData['usuario'];
        $nombre = $postData['nombre'];
        $apellido = $postData['apellido'];
        $email = $postData['email'];
        $imagen = $postData['imagen'] ?? null;

        $data = [
            "id" => $id,
            "usuario" => $usuario,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "email" => $email,
        ];

        $rules = [
            "usuario" => ['required'],
            "nombre" => ['required'],
            "apellido" => ['required'],
            "email" => ['required', 'min:3'],
        ];

        $validator = new Validator($data, $rules);

        if ($validator->passes()) {
            $usuario_obj = new Usuario();

            if (!empty($imagen)) {
                $upload = new FileUpload($imagen);
                // getPublicPath nos retorna la ruta absoluta a la carpeta "public".
                $ruta = App::getPublicPath() . '/img';
                $nombreImagen = date('Ymd_His_') . ".jpg";
                $upload->save($ruta . '/' . $nombreImagen);
                $data["imagen"]  = $nombreImagen;
            }

            $exito = $usuario_obj->editar($id, $data);

            if ($exito) {
                echo json_encode([
                    "success" => true,
                    "msg" => 'El usuario se modific?? con ??xito.',
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "msg" => 'Ocurri?? un error al tratar de modificar el usuario.',
                ]);
            }
        } else {
            $errores =  $validator->getErrores();
            $texto = '';
            foreach ($errores as $error => $val) {
                $texto .= "$val[0] ";
            };
            echo json_encode([
                "success" => false,
                "msg" => $texto
            ]);
        }
    }

    public function eliminar()
    {
        try {
            $this->requiresAuth();

            $id = urlParam('id');

            $usuario = (new Usuario())->traerPorPK($id);
            $nombreImagen = $usuario->getImagen();
            $usuario->eliminar($id);

            // borrar archivo f??sico:
            $ruta = App::getPublicPath() . '/img';

            if ($nombreImagen != 'default.jpg') :
                unlink($ruta . '/' . $nombreImagen);
            endif;

            echo json_encode([
                'success' => true,
                'msg' => 'El usuario ha sido eliminado.',
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }
}
