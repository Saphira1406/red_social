<?php

namespace RedSocial\Controllers;

use RedSocial\Models\Republicacion;
use RedSocial\DB\QueryException;
use RedSocial\Debug\Debug;

class RepublicacionesController extends Controller
{
    public function nuevoGuardar()
    {
        $this->requiresAuth();

        try {

            $inputData = file_get_contents('php://input');
            $postData = json_decode($inputData, true);

            // Captura de datos:       
            $publicaciones_id     = $postData['publicaciones_id'];
            $usuarios_id          = $postData['usuarios_id'];

            $republicacion = new Republicacion();

            if ($republicacion->verSiExiste($publicaciones_id, $usuarios_id)) {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Esta publicación ya está en tu muro, no se puede volver a compartir.',
                ]);
                exit;
            }

            $data = [
                "publicaciones_id"  => $publicaciones_id,
                "usuarios_id"  => $usuarios_id,
            ];
            $exito = $republicacion->crear($data);

            if ($exito) {
                echo json_encode([
                    'success' => true,
                    'msg' => 'La publicación se agregó a tu muro.',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Ocurrió un error inesperado y la publicación no pudo ser agregada a tu muro.',
                ]);
            }
        } catch (QueryException $e) {
            $debugLog = Debug::printQueryException($e);

            $result = [
                'success' => false,
                'msg' => 'Ocurrió un error inesperado y la publicación no pudo ser agregada a tu muro.',
            ];

            if ($debugLog) {
                $result['debugLog'] = $debugLog;
            }

            echo json_encode($result);
        }
    }
}
