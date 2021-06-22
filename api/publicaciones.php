<?php

use RedSocial\Models\Publicacion;
use RedSocial\Validation\Validator;

require_once __DIR__ . '/bootstrap/init.php';
require_once __DIR__ . '/functions/auth.php';

// El token lo seteamos previamente en una cookie, así que de una cookie lo vamos a leer.
$token = $_COOKIE['token'] ?? null;
if (!$token || !parseAndVerifyToken($token)) {
    echo json_encode([
        'success' => false,
        'msg' => 'Se requiere iniciar sesión para realizar esta acción.'
    ]);
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {

            try {
                $id = $_GET['id'];
                $publicacion = new Publicacion;
                $publicacion_por_id = $publicacion->traerPorPk($id);

                $result = new stdClass();
                $result->success = true;
                $result->msg = 'Éxito';

                $response = new stdClass();
                $response->result = $result;
                $response->data = $publicacion_por_id;

                echo json_encode($response);
            } catch (Exception $e) {

                $result = new stdClass();
                $result->success = false;
                $result->msg = $e->getMessage();

                $response = new stdClass();
                $response->result = $result;
                $response->data = null;

                echo json_encode($response);
            }
        } else {
            $publicacion = new Publicacion;
            $publicaciones = $publicacion->traerTodo();
            echo json_encode($publicaciones);
        }
        break;

    case 'POST':
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        //    $categorias_id = $postData['categorias_id'];
        $texto = $postData['texto'];

        sleep(2); // para mostrar el loader

        if (isset($postData['imagen'])) {
            $imagenParts = explode(',', $postData['imagen']);
            $imagenDecoded = base64_decode($imagenParts[1]);

            $imagenNombre = time() . ".jpg";
            file_put_contents('../img/' . $imagenNombre, $imagenDecoded);
        } else {
            $imagenNombre = 'default.jpg';
        }

        $data = [
            "nombre"        => $nombre,
            "categorias_id" => $categorias_id,
        ];

        $rules = [
            "nombre" => ["required", "min:3"],
            "categorias_id" => ["required"],
        ];

        $validator = new Validator($data, $rules);

        if ($validator->passes()) {
            $publicacion = new Publicacion();
            $exito = $publicacion->crear([
                'nombre'        => $nombre,
                'categorias_id' => $categorias_id,
                'descripcion'   => $descripcion,
                'imagen'        => $imagenNombre
            ]);

            if ($exito) {
                echo json_encode([
                    'success' => true,
                    'msg' => 'La publicación se agregó con éxito.',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Ocurrió un error al tratar de agregar la publicación',
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "msg" => $validator->getErrores()
            ]);
        }

        break;

    case 'PUT':
    case 'PATCH':

        $id = $_GET['id'];

        $inputData = file_get_contents('php://input');

        $postData = json_decode($inputData, true);

        $nombre = $postData['nombre'];
        $categorias_id = $postData['categorias_id'];
        $descripcion = $postData['descripcion'];

        sleep(2);
        if (isset($postData['imagen'])) {
            $imagenParts = explode(',', $postData['imagen']);
            $imagenDecoded = base64_decode($imagenParts[1]);
            // Ahí tenemos la imagen ya decodificada en _memoria_.
            // El paso final sería grabar en disco la imagen.
            $imagenNombre = time() . ".jpg";
            file_put_contents('../img/' . $imagenNombre, $imagenDecoded);
        } else {
            $imagenNombre = '';
        }

        $data = [
            'id' => $id,
            'nombre' => $nombre,
            'categorias_id' => $categorias_id,
            'descripcion' => $descripcion,
        ];

        if ($imagenNombre != '') {
            $data['imagen'] = $imagenNombre;
        }

        $rules = [
            "nombre" => ["required", "min:3"],
            "categorias_id" => ["required"],
        ];

        $validator = new Validator($data, $rules);

        if ($validator->passes()) {
            $publicacion = new Publicacion();
            $exito = $publicacion->editar($id, $data);

            if ($exito) {
                echo json_encode([
                    'success' => true,
                    'msg' => 'Los cambios se guardaron con éxito.',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Ocurrió un error al guardar los cambios',
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "msg" => $validator->getErrores()
            ]);
        }

        break;

    case 'DELETE':

        $id = $_GET['id'];
        $publicacion = new Publicacion;
        $exito = $publicacion->eliminar($id);

        if ($exito) {
            echo json_encode([
                'success' => true,
                'msg' => 'La publicación se eliminó con éxito.',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'msg' => 'Ocurrió un error al tratar de eliminar la publicación.',
            ]);
        }

        break;

    default:
        echo json_encode([
            'success' => false,
            'msg' => 'El método HTTP pedido no existe.',
        ]);
}
