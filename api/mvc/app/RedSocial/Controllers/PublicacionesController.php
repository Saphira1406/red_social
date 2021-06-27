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

        // Para pasarle datos a una vista, usamos el segundo parámetro de la función render().
        // Recibe un array asociativo, donde las claves son los nombres de las variables que se van
        // a crear en la vista, y el valor es el contenido de esas variables.
        //        View::render('productos/index', [
        //            // Pedimos que cree en la vista una variable "productos", que contenga lo que tiene la
        //            // variable local de $productos.
        //            'productos' => $productos
        //        ]);

        // Lo anterior, particularmente la parte del array con los datos para la vista, puede llegar
        // a simplificarse un poco, si estamos seguros de que queremos usar para el nombre de la
        // variable de la vista, el mismo nombre que la variable local.
        // La función compact de php genera un array asociativo a partir de los nombres y valores
        // de variables del entorno/ámbito local.
        //        View::render('productos/index', compact('productos'));

        // Si quisiéramos la salida como JSON...
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
    /*
    public function nuevoForm()
    {
        $this->requiresAuth();

        // View::render('productos/nuevo-form');
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

        // Upload de la imagen
        /*
        if (!empty($imagen)) {
            // Hacemos un explode del string de la imagen para obtener la parte que nos interesa.
            $imagenParts = explode(',', $postData['imagen']);

            // Teniendo separado el base64, vamos a decodificarlo a su archivo original (imagen, en este caso),
            // con ayuda de la función base64_decode de php.
            $imagenDecoded = base64_decode($imagenParts[1]);

            // Ahí tenemos la imagen ya decodificada en _memoria_.
            // El paso final sería grabar en disco la imagen.
            $nombreImagen = time() . ".jpg";
            file_put_contents('./img/' . $nombreImagen, $imagenDecoded);
        } else {
            $nombreImagen = '';
        }
*/

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
