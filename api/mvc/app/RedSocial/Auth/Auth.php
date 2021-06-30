<?php

namespace RedSocial\Auth;

use RedSocial\Models\Usuario;

class Auth
{
    /**
     * Intenta autenticar al usuario.
     * Si tiene éxito, retorna true.
     * De lo contrario, retorna false.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        // Buscamos el usuario por su email.
        $user = new Usuario;
        $user = $user->getByEmail($email);

        // Verificamos si hay un usuario.
        if ($user !== null) {
            // Comparamos los passwords.
            if (password_verify($password, $user->getPassword())) {
                // $this->setAsAuthenticated($user);
                return true;
            }
        }
        return false;
    }

    /**
     * Marca el $user como autenticado.
     *
     * @param Usuario $user
     */
    public function setAsAuthenticated(Usuario $user): void
    {
        // $_SESSION['id'] = $user->getId();

        $token = createToken($user->getId());
        setcookie('token', $token, 0, "", "", false, true);
    }

    /**
     * Desautentica al usuario.
     */
    public function logout(): void
    {
        // unset($_SESSION['id']);

        // Borramos la cookie con el token.
        setcookie('token', null, time() - 3600 * 24);
    }

    /**
     * Retorna si el usuario está autenticado o no.
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        // return isset($_SESSION['id']);

        // El token lo seteamos previamente en una cookie, así que de una cookie lo vamos a leer.

        $token = $_COOKIE['token'] ?? null;
        if ($token || !parseAndVerifyToken($token)) {
            /*
            echo json_encode([
                'success' => false,
                'msg' => 'Se requiere iniciar sesión para realizar esta acción.'
            ]);
            exit;
            */
            return true;
        }
        return false;
    }

    /**
     * Retorna el usuario autenticado.
     * Si no está autenticado, retorna null.
     *
     * @return Usuario|null
     */
    public function getUser()
    {
        if (!$this->isAuthenticated()) {
            return null;
        }

        // $usuario = new Usuario;
        // return $usuario->getByPk($_SESSION['id']);
    }
}
