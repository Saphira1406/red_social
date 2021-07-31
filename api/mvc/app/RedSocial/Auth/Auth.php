<?php

namespace RedSocial\Auth;

use RedSocial\Models\Usuario;
use RedSocial\Models\Token;
use RedSocial\DB\QueryException;
use RedSocial\Debug\Debug;

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
     * @throws QueryException
     */
    public function login(string $email, string $password): bool
    {
        try {
            $user = new Usuario;
            $user = $user->getByEmail($email);

            if ($user) {
                if (password_verify($password, $user->getPassword())) {
                    $this->setAsAuthenticated($user);
                    return true;
                }
            }
            return false;
        } catch (QueryException $e) {
            Debug::printQueryException($e);

            echo json_encode([
                'success' => false,
                'msg' => 'Ocurrió un error inesperado y no se pudo completar la acción.',
            ]);
        }
    }

    /**
     * Marca el $user como autenticado.
     *
     * @param Usuario $user
     */
    public function setAsAuthenticated(Usuario $user): void
    {
        $token = Token::createToken($user->getId());
        setcookie('token', $token, 0, "", "", false, true);
    }

    /**
     * Desautentica al usuario.
     */
    public function logout(): void
    {
        setcookie('token', null, time() - 3600 * 24);
    }

    /**
     * Retorna si el usuario está autenticado o no.
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        $token = $_COOKIE['token'] ?? null;
        if ($token || !parseAndVerifyToken($token)) {
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
        $usuario = new Usuario;
        return $usuario->traerPorPK($usuario->getId());
    }
}
