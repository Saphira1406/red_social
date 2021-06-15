<?php

namespace DaVinci\Controllers;

use DaVinci\Auth\Auth;
use DaVinci\Core\App;
use DaVinci\Core\Route;
use DaVinci\Core\View;
use DaVinci\Models\Publicacion;
use DaVinci\Validation\Validator;

class PublicacionesController extends Controller
{
    public function listado()
    {
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


    public function nuevoForm()
    {
        $this->requiresAuth();

        View::render('productos/nuevo-form');
    }

    public function nuevoGuardar()
    {
        $this->requiresAuth();

        // Validamos usando la clase Validator, que más adelante haremos desde 0 en clase.
        $validator = new Validator($_POST, [
            'nombre'        => ['required', 'min:3'],
            'id_categoria'  => ['required', 'numeric'],
            'id_marca'      => ['required', 'numeric'],
            'precio'        => ['required', 'numeric'],
        ]);

        if(!$validator->passes()) {
            $_SESSION['error'] = 'Ocurrieron errores de validación';
//            header('Location: ./../producto-nuevo.php');
            App::redirect('/productos/nuevo');
            exit;
        }

        // Captura de datos.
        $nombre             = $_POST['nombre'];
        $id_categoria       = $_POST['id_categoria'];
        $id_marca           = $_POST['id_marca'];
        $precio             = $_POST['precio'];
        $cuotas_sin_interes = $_POST['cuotas_sin_interes'];
        $descripcion        = $_POST['descripcion'];

        $producto = new Producto();
        $exito = $producto->crear([
            'nombre' => $nombre,
            'id_marca' => $id_marca,
            'id_categoria' => $id_categoria,
            'precio' => $precio,
            'cuotas_sin_interes' => $cuotas_sin_interes,
            'descripcion' => $descripcion,
        ]);

        if($exito) {
            $_SESSION['error'] = 'Ocurrieron errores de validación';
            App::redirect('/productos');
        } else {
            $_SESSION['error'] = 'Ocurrió un error al grabar el producto.';
            App::redirect('/productos/nuevo');
        }
    }

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
