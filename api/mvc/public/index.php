<?php
// # CORS
// Vamos a configurar para que nuestro backend (esta API) acepte peticiones de dominios diferentes
// al propio (ej: nuestra app de Vue).
// CORS se configura a través de unos headers de HTTP. En particular, los que empiezan con
// "Access-Control".
// Para empezar, va a haber 2 headers por lo menos que queremos configurar.
// 1. Access-Control-Allow-Origin
//      Este header define una lista de los dominios a los que permitimos que nos hagan peticiones.
//      Opcionalmente pueden poner "*" para permitir cualquier dominio (nota: dependiendo de otros
//      esto puede no permitirse).

header("Access-Control-Allow-Origin: http://localhost:8080");
// 2. Access-Control-Allow-Methods
//      Este header define una lista con los métodos de HTTP que permitimos que tengan las peticiones.
//      En una API REST, generalmente hay 6 que vamos a necesitar habilitar.
//      Esos 6 son los 5 de REST, y OPTIONS, que es necesario para ciertas funciones de CORS.
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");

header("Access-Control-Allow-Headers: Content-Type");

header("Access-Control-Allow-Credentials: true");



session_start();

// Antes que nada, requerimos el autoload.
require __DIR__ . '/../autoload.php';

require_once __DIR__ . '/../app/Helpers/routes.php';

// Guardamos la ruta absoluta de base del proyecto.
$rootPath = realpath(__DIR__ . '/../');

// Normalizamos las \ a /
$rootPath = str_replace('\\', '/', $rootPath);

// Requerimos las rutas de la aplicación.
require $rootPath . '/app/routes.php';

// Instanciamos nuestra App.
$app = new \RedSocial\Core\App($rootPath);

// Arrancamos la App.
$app->run();
