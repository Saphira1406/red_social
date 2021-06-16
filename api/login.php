<?php
require_once __DIR__ . '/../autoload.php';

header("Content-Type: application/json");

// session_start();

$inputData = file_get_contents('php://input');
$postData = json_decode($inputData, true);

$email = trim($postData['email']);
$password = $postData['password'];

$auth = new Authentication();
$success = $auth->login($email, $password);

if ($auth->login($email, $password)) {
    // $_SESSION['id'] = $fila['id'];
    echo json_encode([
        'success' => true,
        'msg' => 'El producto se insertó con éxito.',
    ]);
} else {
    echo json_encode([
        'success' => false,
        'msg' => 'Ocurrió un error al tratar de insertar el producto.',
    ]);
}

// Vamos a autenticar al usuario con los datos que nos llegan en el JSON.
/*
header("Content-Type: application/json");

session_start();

$db = mysqli_connect('localhost', 'root', '', 'cwm');
mysqli_set_charset($db, 'utf8mb4');

$inputData = file_get_contents('php://input');
$postData = json_decode($inputData, true);

$email = mysqli_real_escape_string($db, $postData['email']);
$password = $postData['password'];

$query = "SELECT * FROM usuarios
            WHERE email = '{$email}'";
$res = mysqli_query($db, $query);

if($fila = mysqli_fetch_assoc($res)) {
    if(password_verify($password, $fila['password'])) {
        $_SESSION['id'] = $fila['id'];

        echo json_encode([
            'success' => true,
            'data' => [
                'id' => $fila['id'],
                'usuario' => $fila['usuario'],
            ]
        ]);
        exit;
    }
}

echo json_encode([
    'success' => false,
]);
*/