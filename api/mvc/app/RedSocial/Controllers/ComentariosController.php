<?php

namespace RedSocial\Controllers;

use RedSocial\Auth\Auth;
use RedSocial\Core\App;
use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Publicacion;
use RedSocial\Models\Comentario;
use RedSocial\Validation\Validator;
use RedSocial\Storage\FileUpload;

class ComentariosController extends Controller
{
    public function listado()
    {
        $this->requiresAuth();
        $comentarios = (new Publicacion())->traerTodo();
        // Si quisiéramos la salida como JSON...
        View::renderJson($comentarios);
    }
    /*
    public function ver()
    {
        // Capturamos el parámetro de la URL que definidos en la ruta.
//        $params = Route::getUrlParameters();
//        $id = $params['id'];
        $id = Route::getUrlParameters()['id'];

//        echo "El id que pidieron es: " . $id;
        $producto = (new Producto())->traerPorPK($id);

        View::render('productos/ver', compact('producto'));
//        View::renderJson($producto);
    }

*/
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
                    'msg' => 'La publicación se creó con éxito.',
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'msg' => 'Ocurrió un error inesperado y la publicación no pudo ser creada.',
                ]);
            }
        } else {
            // $_SESSION['error'] = 'Ocurrieron errores de validación';
            //            header('Location: ./../producto-nuevo.php');
            // App::redirect('/productos/nuevo');
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
    /*
    public function eliminar()
    {
        $this->requiresAuth();

        $id = urlParam('id');
        $producto = new Producto();
        if(!$producto->eliminar($id)) {
            $_SESSION['error'] = 'Ocurrió un error al tratar de guardar la información.';
            App::redirect('/productos');
            exit;
        }
        $_SESSION['exito'] = 'El producto fue eliminado exitosamente.';
        App::redirect('/productos');
    }
    */
}
