<?php

namespace RedSocial\Controllers;

use RedSocial\Auth\Auth;
use RedSocial\Core\App;
use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Publicacion;
use RedSocial\Validation\Validator;
use RedSocial\Storage\FileUpload;

class PublicacionesController extends Controller
{
    public function listado()
    {
        $this->requiresAuth();
        $publicaciones = (new Publicacion())->traerTodo();
        View::renderJson($publicaciones);
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

        $data = [
            "texto"  => $texto,
            "usuarios_id"  => $usuarios_id,
            "imagen"  => $nombreImagen,
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
