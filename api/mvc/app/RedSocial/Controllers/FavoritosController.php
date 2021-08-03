<?php


namespace RedSocial\Controllers;

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

        $data = [
            "usuarios_id"  => $usuarios_id,
            "publicaciones_id"  => $publicaciones_id,
        ];

        $favorito = new Favorito();
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

        $amigo = (new Favorito)->traerPorPK($id);

        if (!$amigo->eliminar($id)) {
            echo json_encode([
                "success" => false,
                "msg" => 'Ocurrió un error al tratar de eliminar el favorito.',
            ]);
        } else {

            echo json_encode([
                'success' => true,
                'msg' => 'El favorito ha sido eliminado',
            ]);
        }
    }
}
