<?php

namespace RedSocial\Controllers;

use RedSocial\Core\App;
use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Publicacion;
use RedSocial\Validation\Validator;
use RedSocial\Storage\FileUpload;

class PublicacionesController extends Controller
{
    public function listado()
    {
        $this->requiresAuth();
        $publicaciones = (new Publicacion())->traerTodo();
        View::renderJson($publicaciones);
    }

    public function ver()
    {
        $id = Route::getUrlParameters()['id'];

        $publicacion = (new Publicacion())->traerPorPK($id);

        View::renderJson($publicacion);
    }

    public function nuevoGuardar()
    {
        $this->requiresAuth();

        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        // Captura de datos:       
        $texto             = $postData['texto'];
        $usuarios_id       = $postData['usuarios_id'];
        $imagen            = $postData['imagen'] ?? null;

        if (!empty($imagen)) {
            $upload = new FileUpload($imagen);
            // getPublicPath nos retorna la ruta absoluta a la carpeta "public".
            $ruta = App::getPublicPath() . '/img';
            $nombreImagen = date('Ymd_His_') . ".jpg";
            $upload->save($ruta . '/' . $nombreImagen);
        } else {
            $nombreImagen = '';
        }

        $data = [
            "texto"  => $texto,
            "usuarios_id"  => $usuarios_id,
            "imagen"  => $nombreImagen,
        ];

        $rules = [
            "texto" => ["required", 'min:3'],
        ];

        $validator = new Validator($data, $rules);

        if ($validator->passes()) {
            $publicacion = new Publicacion();
            $exito = $publicacion->crear($data);

            if ($exito) {
                echo json_encode([
                    'success' => true,
                    'msg' => 'La publicación se creó con éxito.',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Ocurrió un error inesperado y la publicación no pudo ser creada.',
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
}
