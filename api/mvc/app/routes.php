<?php
/*
 * Este archivo va a contener TODAS las rutas de
 * nuestra aplicación.
 *
 * Para esto, vamos a crear una clase Route cuya
 * función sea la de registrar y administrar las rutas.
 */

use RedSocial\Core\Route;

// Registramos la primer ruta! :D
// Route es la clase encargada del manejo de las rutas.
// Tiene un método estático "add" que permite registrar una ruta en el sistema.
// El tercer parámetro es el método del controller que debe ejecutar la ruta.
// El formato que usa es:
// "NombreController@método"
// Los Controllers están en su correspondiente carpeta en app.
Route::add('GET', '/', 'HomeController@index');

/*
 |--------------------------------------------------------------------------
 | Autenticación
 |--------------------------------------------------------------------------
 */
// Route::add('GET', '/iniciar-sesion', 'AuthController@loginForm');
Route::add('POST', '/iniciar-sesion', 'AuthController@loginProcesar');
Route::add('POST', '/cerrar-sesion', 'AuthController@logout');

/*
 |--------------------------------------------------------------------------
 | Publicaciones
 |--------------------------------------------------------------------------
 */
// Registramos una ruta para el listado de publicaciones.
Route::add('GET', '/publicaciones', 'PublicacionesController@listado');

// Route::add('GET', '/publicaciones/nuevo', 'PublicacionesController@nuevoForm');

// Hacemos la ruta para grabar.
// Cuando usamos URLs amigables, es frecuente que usemos la misma exacta URL que el form que
// recolecta la data, pero con el method diferente.
Route::add('POST', '/publicaciones/nuevo', 'PublicacionesController@nuevoGuardar');

// Registramos una ruta para el detalle de cada publicación.
// Ahora la pregunta, ¿Cómo indicamos un parámetro en la ruta que puede variar?
// Para ver el detalle de la publicación, las rutas van a ser algo como:
// /publicaciones/14
// Para lograr esto, tenemos los "parámetros" para las URLs, que se indican con {nombre} (donde nombre
// es una clave arbitraria con la que luego podemos obtener el valor).
Route::add('GET', '/publicaciones/{id}', 'PublicacionesController@ver');

// Hacemos el eliminar.
// Nota: Si esto fuera una API REST, entonces el verbo sería DELETE.
Route::add('DELETE', '/publicaciones/{id}/eliminar', 'PublicacionesController@eliminar');

/*
 |--------------------------------------------------------------------------
 | Usuarios
 |--------------------------------------------------------------------------
 */

// Hacemos la ruta para grabar.
Route::add('POST', '/usuarios/nuevo', 'UsuariosController@nuevoGuardar');

// Registramos una ruta para el detalle de cada usuario.
Route::add('GET', '/usuarios/{id}', 'UsuariosController@ver');

// Hacemos el eliminar.
// Nota: Si esto fuera una API REST, entonces el verbo sería DELETE.
Route::add('DELETE', '/usuarios/{id}/eliminar', 'UsuariosController@eliminar');
