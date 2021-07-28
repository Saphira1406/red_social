<?php

namespace RedSocial\Controllers;

use RedSocial\Core\App;
use RedSocial\Models\Comentario;
use RedSocial\Validation\Validator;
use RedSocial\Validation\EmptyFieldsException;
use RedSocial\Validation\NotExistentRuleException;
use \DateTime;
use \DateTimeZone;

class ComentariosController extends Controller
{
    public function nuevoGuardar()
    {
        $this->requiresAuth();

        try {
            $inputData = file_get_contents('php://input');
            $postData = json_decode($inputData, true);

            // Captura de datos:       
            $texto              = $postData['texto'];
            $usuarios_id        = $postData['usuarios_id'];
            $publicaciones_id   = $postData['publicaciones_id'];

            $fecha = new DateTime(null, new DateTimeZone(App::getEnv('TIMEZONE')));

            $data = [
                "texto"  => $texto,
                "usuarios_id"  => $usuarios_id,
                "publicaciones_id"  => $publicaciones_id,
                "fecha" => $fecha->format('Y-m-d H:i:s'),
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
        }
    }
}
