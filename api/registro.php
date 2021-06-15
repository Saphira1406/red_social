<?php

use DaVinci\Models\Usuario;
use DaVinci\Validation\Validator;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require __DIR__ . '/mvc/autoload.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $inputData = file_get_contents('php://input');
    $postData = json_decode($inputData, true);

    $nombre = $postData['nombre'];
    $apellido = $postData['apellido'];
    $email = $postData['email'];
    $password = $postData['password'];

    $data = [
        "nombre"  => $nombre,
        "apellido"  => $apellido,
        "email"    => $email,
        "password" => $password,
    ];

    $rules = [
        "email" => ["required"],
        "password" => ["required", "min:3"],
    ];

    $validator = new Validator($data, $rules);

    if ($validator->passes()) {
        $password = password_hash($postData['password'], PASSWORD_DEFAULT);
        $usuario_obj = new Usuario();
        $exito = $usuario_obj->crear([
            "nombre"  => $nombre,
            "apellido"  => $apellido,
            'email' => $email,
            'password' => $password,
        ]);

        if ($exito) {
            echo json_encode([
                'success' => true,
                'msg' => 'El usuario se registró con éxito. Redireccionando...',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'msg' => 'Ocurrió un error al tratar de registrar el usuario.',
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "msg" => $validator->getErrores()
        ]);
    }
}
