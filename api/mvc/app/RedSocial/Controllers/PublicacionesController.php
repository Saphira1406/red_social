<?php

namespace RedSocial\Controllers;

use RedSocial\Auth\Auth;
use RedSocial\Core\App;
use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Publicacion;
use RedSocial\Validation\Validator;

class PublicacionesController extends Controller
{
    public function listado()
    {
        // El token lo seteamos previamente en una cookie, así que de una cookie lo vamos a leer.
        /*
        $token = $_COOKIE['token'] ?? null;
        if (!$token || !parseAndVerifyToken($token)) {
            echo json_encode([
                'success' => false,
                'msg' => 'Se requiere iniciar sesión para realizar esta acción.'
            ]);
            exit;
        }
*/
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
        $inputData = file_get_contents('php://input');
        $postData = json_decode($inputData, true);

        $this->requiresAuth();

        // Validamos usando la clase Validator, que más adelante haremos desde 0 en clase.      
        $validator = new Validator($postData, [
            'texto'        => ['required', 'min:3'],
        ]);

        if (!$validator->passes()) {
            // $_SESSION['error'] = 'Ocurrieron errores de validación';
            //            header('Location: ./../producto-nuevo.php');
            // App::redirect('/productos/nuevo');
            exit;
        }

        // Captura de datos.       
        $texto             = $postData['texto'];
        $usuarios_id       = $postData['usuarios_id'];

        $publicacion = new Publicacion();
        $exito = $publicacion->crear([
            'texto' => $texto,
            'usuarios_id' => $usuarios_id,

        ]);

        if ($exito) {
            echo json_encode([
                'success' => true,
                'msg' => 'Publicación creada exitosamente.',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'msg' => 'Ocurrieron errores de validación.',
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
