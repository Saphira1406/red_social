<?php

use RedSocial\Auth\Auth;
use RedSocial\Models\Usuario;

require_once __DIR__ . '/bootstrap/init.php';
require_once __DIR__ . '/functions/auth.php';

require __DIR__ . '/mvc/autoload.php';

// session_start();

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
        $token = createToken($usuario->getId());
        $cookie = setcookie('token', $token, 0, "", "", false, true);

        echo json_encode([
            'success' => true,
            'data' => [
                'id' => $usuario->getId(),
                'usuario' => $usuario->getUsuario(),
                'imagen' => $usuario->getImagen(),
                'nombre' => $usuario->getNombre(),
                'apellido' => $usuario->getApellido(),
                'email' => $email,
            ]
        ]);
        exit;
    }
}
echo json_encode([
    'success' => false,
    'msg' => 'Ocurrió un error al tratar de loguearse.',
]);
