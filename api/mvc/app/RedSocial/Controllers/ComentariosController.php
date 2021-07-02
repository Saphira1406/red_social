<?php

namespace RedSocial\Controllers;

use RedSocial\Models\Comentario;
use RedSocial\Validation\Validator;

class ComentariosController extends Controller
{
    public function nuevoGuardar()
    {
        $this->requiresAuth();

        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        // Captura de datos:       
        $texto              = $postData['texto'];
        $usuarios_id        = $postData['usuarios_id'];
        $publicaciones_id   = $postData['publicaciones_id'];

        $data = [
            "texto"  => $texto,
            "usuarios_id"  => $usuarios_id,
            "publicaciones_id"  => $publicaciones_id,
        ];

        $rules = [
            "texto" => ["required"],
        ];

        $validator = new Validator($data, $rules);

        if ($validator->passes()) {
            $comentario = new Comentario();
            $exito = $comentario->crear($data);

            if ($exito) {
                echo json_encode([
                    'success' => true,
                    'msg' => 'El comentario se creó con éxito.',

                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Ocurrió un error inesperado y el comentario no pudo ser creado.',
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
