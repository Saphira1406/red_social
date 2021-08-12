<?php

namespace RedSocial\Controllers;

use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Amigo;
use Exception;
use RedSocial\DB\QueryException;
use RedSocial\Debug\Debug;

class AmigosController extends Controller
{
    public function listado()
    {
        $this->requiresAuth();
        $id = Route::getUrlParameters()['id'];
        $amigos = (new Amigo())->traerTodos($id);
        View::renderJson($amigos);
    }

    public function nuevoGuardar()
    {
        $this->requiresAuth();

        try {

            $inputData = file_get_contents('php://input');
            $postData = json_decode($inputData, true);

            // Captura de datos:       
            $emisor_id         = $postData['emisor_id'];
            $receptor_id       = $postData['receptor_id'];

            $amigo = new Amigo();

            if ($amigo->verSiExiste($emisor_id, $receptor_id)) {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Esta amistad ya existe, no se puede volver a agregar.',
                ]);
                exit;
            }

            $data = [
                "emisor_id"  => $emisor_id,
                "receptor_id"  => $receptor_id,
            ];

            $exito = $amigo->crear($data);

            if ($exito) {
                echo json_encode([
                    'success' => true,
                    'msg' => 'Amistad creada con éxito.',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Ocurrió un error inesperado y no se pudo crear la amistad.',
                ]);
            }
        } catch (QueryException $e) {
            $debugLog = Debug::printQueryException($e);

            $result = [
                'success' => false,
                'msg' => 'Ocurrió un error inesperado y no se pudo crear la amistad.',
            ];

            if ($debugLog) {
                $result['debugLog'] = $debugLog;
            }

            echo json_encode($result);
        }
    }

    public function eliminar()
    {
        $this->requiresAuth();

        $id = urlParam('id');

        $amigo = (new Amigo())->traerPorPK($id);

        try {
            $amigo->eliminar($id);
            echo json_encode([
                'success' => true,
                'msg' => 'La amistad ha sido eliminada exitosamente.',
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }
}
