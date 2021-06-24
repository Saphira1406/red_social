<?php

namespace RedSocial\Controllers;

use RedSocial\Auth\Auth;
use RedSocial\Core\App;
use RedSocial\Core\Route;
use RedSocial\Core\View;
use RedSocial\Models\Usuario;
use RedSocial\Validation\Validator;

class UsuariosController extends Controller
{
    public function ver()
    {
        // Capturamos el parámetro de la URL que definidos en la ruta.
        //        $params = Route::getUrlParameters();
        //        $id = $params['id'];
        $id = Route::getUrlParameters()['id'];

        //        echo "El id que pidieron es: " . $id;
        $usuario = (new Usuario())->getByPk($id);

        //        View::render('usuarios/ver', compact('usuario'));
        View::renderJson($usuario);
    }
    /*
    public function eliminar()
    {
        $this->requiresAuth();

        $id = urlParam('id');
        $usuario = new Usuario();
        if(!$usuario->eliminar($id)) {
            $_SESSION['error'] = 'Ocurrió un error al tratar de guardar la información.';
         //   App::redirect('/usuarios');
            exit;
        }
        $_SESSION['exito'] = 'El usuario fue eliminado exitosamente.';
      //  App::redirect('/usuarios');
    }
    */
}
