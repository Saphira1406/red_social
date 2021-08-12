<?php

namespace RedSocial\Controllers;

use RedSocial\Core\App;
use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\DB\QueryException;
use RedSocial\Debug\Debug;
use RedSocial\Models\Publicacion;
use RedSocial\Validation\Validator;
use RedSocial\Validation\EmptyFieldsException;
use RedSocial\Validation\NotExistentRuleException;
use RedSocial\Storage\FileUpload;
use RedSocial\Storage\InvalidFileTypeException;
use \DateTime;
use \DateTimeZone;

class PublicacionesController extends Controller
{
    public function listado()
    {
        try {
            $this->requiresAuth();
            $publicaciones = (new Publicacion())->traerTodo();

            $result = [
                'success' => true,
                'publicaciones' => $publicaciones,
            ];
        } catch (QueryException $e) {
            $debugLog = Debug::printQueryException($e);

            $result = [
                'success' => false,
                'msg' => 'Ocurrió un error inesperado y no se pudo cargar las publicaciones.',
            ];

            if ($debugLog) {
                $result['debugLog'] = $debugLog;
            }
        }
        echo json_encode($result);
    }

    public function usuario()
    {
        $this->requiresAuth();
        try {

            $usuarios_id = Route::getUrlParameters()['id'];
            $publicaciones = (new Publicacion())->traerPorUsuario($usuarios_id);

            $result = [
                'success' => true,
                'publicaciones' => $publicaciones,
            ];
        } catch (QueryException $e) {
            $debugLog = Debug::printQueryException($e);

            $result = [
                'success' => false,
                'msg' => 'Ocurrió un error inesperado y no se pudo cargar los favoritos del usuario.',
            ];

            if ($debugLog) {
                $result['debugLog'] = $debugLog;
            }
        }
        echo json_encode($result);
    }

    public function nuevoGuardar()
    {
        $this->requiresAuth();

        try {

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

            $fecha = new DateTime(null, new DateTimeZone(App::getEnv('TIMEZONE')));

            $data = [
                "texto"  => $texto,
                "usuarios_id"  => $usuarios_id,
                "imagen"  => $nombreImagen,
                "fecha" => $fecha->format('Y-m-d H:i:s'),
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
        } catch (InvalidFileTypeException $e) {
            echo json_encode([
                'success' => false,
                'msg' => 'El formato del archivo no es correcto, se recibió: ' . $e->getFileType(),
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
            Debug::printQueryException($e);

            echo json_encode([
                'success' => false,
                'msg' => 'Ocurrió un error inesperado y la publicación no pudo ser creada.',
            ]);
        }
    }
}
