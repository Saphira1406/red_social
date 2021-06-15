<?php
// Definimos un autoload.
spl_autoload_register(function($className) {
    // Cambiamos las \ a /
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    // Le agregamos la extensión de php, y la carpeta de
    // base "app/".
    $filepath = __DIR__ . '/app/' . $className . ".php";

    // Verificamos si existe, y en caso positivo,
    // incluimos la clase.
    if(file_exists($filepath)) {
        require_once $filepath;
    }
});
