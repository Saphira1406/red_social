<?php
require_once __DIR__ . '/bootstrap/init.php';
require_once __DIR__ . '/functions/auth.php';


// $_SERVER['REQUEST_METHOD'] retorna el método de la petición.
switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Verificamos si está el valor del query string "id".
        // Si lo está, buscamos el producto por su id.
        // Sino, retornamos todos.
        if(isset($_GET['id'])) {
            // A diferencia de POST, esta parte no cambia en REST como lo estamos usando.
            $id = (int) $_GET['id'];

            $query = "SELECT * FROM productos
                        WHERE id_producto = {$id}";

            $res = mysqli_query($db, $query);

            echo json_encode(mysqli_fetch_assoc($res));
        } else {
            $query = "SELECT * FROM productos";

            $res = mysqli_query($db, $query);

            $datos = [];

            while($fila = mysqli_fetch_assoc($res)) {
                $datos[] = $fila;
            }

            echo json_encode($datos);
        }
    //        $productos = productosTraerTodos($db);
    //        echo json_encode($productos);
        break;

    case 'POST':
        // El token lo seteamos previamente en una cookie, así que de una cookie lo vamos a leer.
        $token = $_COOKIE['token'] ?? null;
        if(!$token || !parseAndVerifyToken($token)) {
            echo json_encode([
                'success' => false,
                'msg' => 'Se requiere iniciar sesión para realizar esta acción.'
            ]);
            exit;
        }

        // 1. Leer el búffer de entrada de php, con ayuda de la función file_get_contents.
        // El búffer de entrada es donde php almacena el contenido completo del cuerpo de la petición.
        // En este caso, sería el objeto JSON que nois enviaron.
        $inputData = file_get_contents('php://input');
//    die($inputData);
        // 2. Parsear el JSON obtenido.
        $postData = json_decode($inputData, true);
        // Sacamos los datos obtenidos del objeto JSON a variables independientes.
        $nombre         = mysqli_real_escape_string($db, $postData['nombre']);
        $precio         = (float) $postData['precio'];
        $id_categoria   = (int) $postData['id_categoria'];
        $id_marca       = (int) $postData['id_marca'];
        $descripcion    = mysqli_real_escape_string($db, $postData['descripcion']);
        $imagen         = $postData['imagen'] ?? null;

        // Upload de la imagen
        if(!empty($imagen)) {
            // Hacemos un explode del string de la imagen para obtener la parte que nos interesa.
            $imagenParts = explode(',', $postData['imagen']);

            // Teniendo separado el base64, vamos a decodificarlo a su archivo original (imagen, en este caso),
            // con ayuda de la función base64_decode de php.
            $imagenDecoded = base64_decode($imagenParts[1]);

            // Ahí tenemos la imagen ya decodificada en _memoria_.
            // El paso final sería grabar en disco la imagen.
            $imagenNombre = time() . ".jpg";
            file_put_contents('./imgs/' . $imagenNombre, $imagenDecoded);
        } else {
            $imagenNombre = '';
        }

        // TODO: Validar...

        $query = "INSERT INTO productos (nombre, precio, id_categoria, id_marca, descripcion, imagen)
            VALUES ('{$nombre}', '{$precio}', '{$id_categoria}', '{$id_marca}', '{$descripcion}', '{$imagenNombre}')";

        $exito = mysqli_query($db, $query);

        if($exito) {
            echo json_encode([
                'success' => true,
                'msg' => 'El producto se insertó con éxito.',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'msg' => 'Ocurrió un error al tratar de insertar el producto :(',
//                'error' => mysqli_error($db),
            ]);
        }
        break;

    case 'PUT':
        // PUT funciona igual que POST.
        // Es decir, enviamos los datos en el cuerpo de la petición, y los parseamos leyendo el
        // php://input y pasándole el resultado al json_decode.
        // La única excepción es el id, que como siempre, va en el query string, y lo sacamos de $_GET.
        break;

    case 'PATCH':
        break;

    case 'DELETE':
        // El token lo seteamos previamente en una cookie, así que de una cookie lo vamos a leer.
        $token = $_COOKIE['token'] ?? null;
        if(!$token || !parseAndVerifyToken($token)) {
            echo json_encode([
                'success' => false,
                'msg' => 'Se requiere iniciar sesión para realizar esta acción.'
            ]);
            exit;
        }

        // DELETE se comporta en general igual que GET.
        // Pasan los datos en el query string, como el id del producto a eliminar, y los capturan
        // en php con $_GET.
        $id = (int) $_GET['id'];
        $query = "DELETE FROM productos
                WHERE id_producto = " . $id;
        $exito = mysqli_query($db, $query);
        if($exito) {
            echo json_encode([
                'success' => true,
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'msg' => 'Ocurrió un error inesperado al tratar de eliminar el producto.'
            ]);
        }
        break;

    default:
        echo json_encode([
            'success' => false,
            'El método HTTP pedido no existe.',
        ]);
}
