<?php


namespace RedSocial\Controllers;

use Exception;
use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Favorito;


class FavoritosController extends Controller
{

    public function listado()
    {
        $this->requiresAuth();
        $id = Route::getUrlParameters()['id'];
        $favoritos = (new Favorito())->traerTodos($id);
        View::renderJson($favoritos);
    }

    public function nuevoGuardar()
    {
        $this->requiresAuth();

        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        // Captura de datos:
        $usuarios_id         = $postData['usuarios_id'];
        $publicaciones_id       = $postData['publicaciones_id'];

        $favorito = new Favorito();

        if ($favorito->verSiExiste($publicaciones_id, $usuarios_id)) {
            echo json_encode([
                'success' => false,
                'msg' => 'Ya agregaste esta publicación a Favoritos, no se puede volver a agregar.',
            ]);
            exit;
        }

        $data = [
            "usuarios_id"  => $usuarios_id,
            "publicaciones_id"  => $publicaciones_id,
        ];

        $exito = $favorito->crear($data);

        if ($exito) {
            echo json_encode([
                'success' => true,
                'msg' => 'Favorito agregado con éxito.',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'msg' => 'Ocurrió un error inesperado y no se pudo agregar el favorito.',
            ]);
        }
    }

    public function eliminar()
    {
        $this->requiresAuth();
        $id = urlParam('id');
        $favorito = (new Favorito)->traerPorPK($id);

        try {
            $favorito->eliminar($id);
            echo json_encode([
                'success' => true,
                'msg' => 'El favorito ha sido eliminado exitosamente.',
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }
}
