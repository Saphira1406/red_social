<?php


namespace RedSocial\Controllers;

use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Favoritos;


class FavoritosController extends Controller
{

    public function listado()
    {
        $this->requiresAuth();
        $id = Route::getUrlParameters()['id'];
        $amigos = (new Favoritos())->traerTodos($id);
        View::renderJson($amigos);
    }

    public function nuevoGuardar()
    {
        $this->requiresAuth();

        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        // Captura de datos:
        $emisor_id         = $postData['emisor_id'];
        $receptor_id       = $postData['receptor_id'];

        $data = [
            "emisor_id"  => $emisor_id,
            "receptor_id"  => $receptor_id,
        ];

        $amigo = new Favoritos();
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
    }

    public function eliminar()
    {
        $this->requiresAuth();

        $id = urlParam('id');

        $amigo = (new Favoritos)->getByPk($id);

        if (!$amigo->eliminar($id)) {
            echo json_encode([
                "success" => false,
                "msg" => 'Ocurrió un error al tratar de eliminar el amigo.',
            ]);
        } else {

            echo json_encode([
                'success' => true,
                'msg' => 'El amigo ha sido eliminado',
            ]);
        }
    }
}