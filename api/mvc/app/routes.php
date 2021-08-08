<?php
/*
 * Este archivo va a contener TODAS las rutas de
 * nuestra aplicación.
 *
 * Para esto, vamos a crear una clase Route cuya
 * función sea la de registrar y administrar las rutas.
 */

use RedSocial\Core\Route;

// Route::add('GET', '/', 'HomeController@index');

/*
 |--------------------------------------------------------------------------
 | Autenticación
 |--------------------------------------------------------------------------
 */

Route::add('POST', '/iniciar-sesion', 'AuthController@loginProcesar');
Route::add('POST', '/cerrar-sesion', 'AuthController@logout');

/*
 |--------------------------------------------------------------------------
 | Publicaciones
 |--------------------------------------------------------------------------
 */

Route::add('GET', '/publicaciones', 'PublicacionesController@listado');

Route::add('POST', '/publicaciones/nuevo', 'PublicacionesController@nuevoGuardar');

// Mostrar publicaciones de un usuario según el id del mismo:
Route::add('GET', '/publicaciones/{id}', 'PublicacionesController@usuario');

Route::add('DELETE', '/publicaciones/{id}/eliminar', 'PublicacionesController@eliminar');

/*
 |--------------------------------------------------------------------------
 | Usuarios
 |--------------------------------------------------------------------------
 */

Route::add('POST', '/usuarios/nuevo', 'UsuariosController@nuevoGuardar');

Route::add('GET', '/usuarios/{id}', 'UsuariosController@ver');

// Rutas para editar el usuario:
Route::add('PUT', '/usuarios/{id}/editar', 'UsuariosController@editarUsuario');
Route::add('OPTIONS', '/usuarios/{id}/editar', 'AuthController@options');

// Rutas para eliminar el usuario:
Route::add('DELETE', '/usuarios/{id}/eliminar', 'UsuariosController@eliminar');
Route::add('OPTIONS', '/usuarios/{id}/eliminar', 'AuthController@options');

/*
 |--------------------------------------------------------------------------
 | Comentarios
 |--------------------------------------------------------------------------
 */

// Hacemos la ruta para grabar:
Route::add('POST', '/comentarios/nuevo', 'ComentariosController@nuevoGuardar');

/*
 |--------------------------------------------------------------------------
 | Amigos
 |--------------------------------------------------------------------------
 */

Route::add('GET', '/amigos/{id}', 'AmigosController@listado');
Route::add('POST', '/amigos/nuevo', 'AmigosController@nuevoGuardar');

// Rutas para eliminar un amigo:
Route::add('DELETE', '/amigos/{id}/eliminar', 'AmigosController@eliminar');
Route::add('OPTIONS', '/amigos/{id}/eliminar', 'AuthController@options');

/*
 |--------------------------------------------------------------------------
 | Favoritos
 |--------------------------------------------------------------------------
 */

Route::add('GET', '/favoritos/{id}', 'FavoritosController@listado');
Route::add('POST', '/favoritos/nuevo', 'FavoritosController@nuevoGuardar');

// Rutas para eliminar un favorito:
Route::add('DELETE', '/favoritos/{id}/eliminar', 'FavoritosController@eliminar');
Route::add('OPTIONS', '/favoritos/{id}/eliminar', 'AuthController@options');

/*
 |--------------------------------------------------------------------------
 | Republicaciones
 |--------------------------------------------------------------------------
 */

Route::add('POST', '/republicaciones/nuevo', 'RepublicacionesController@nuevoGuardar');
