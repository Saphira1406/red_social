<?php

use RedSocial\Auth\Auth;
use RedSocial\Models\Usuario;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require __DIR__ . '/mvc/autoload.php';

session_start();

$inputData = file_get_contents('php://input');
$postData = json_decode($inputData, true);

$email = trim($postData['email']);
$password = $postData['password'];

$auth = new Auth();
$success = $auth->login($email, $password);

if ($auth->login($email, $password)) {

    $usuario = new Usuario();
    $usuario = $usuario->getByEmail($email);

    if ($usuario) {
        //     $_SESSION['id'] = $usuario->getId();

        echo json_encode([
            'success' => true,
            'data' => [
                'id' => $usuario->getId(),
                'usuario' => $usuario->getUsuario(),
                'email' => $email,
            ]
        ]);
        exit;
    }
}
echo json_encode([
    'success' => false,
    'msg' => 'Ocurrió un error al tratar de insertar el producto.',
]);
