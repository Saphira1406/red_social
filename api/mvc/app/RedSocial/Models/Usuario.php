<?php

namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use RedSocial\DB\QueryException;
use JsonSerializable;
use PDO;
use PDOException;

class Usuario extends Modelo implements JsonSerializable
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = 'usuarios';

    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [
        'id',
        'usuario',
        'password',
        'email',
        'nombre',
        'apellido',
        'imagen',
    ];

    private $id;
    private $usuario;
    private $password;
    private $email;
    private $nombre;
    private $apellido;
    private $imagen;

    public function editar(int $id, array $data): bool
    {
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        if (!$fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return false;
        }

        $queryEditar = "UPDATE usuarios SET
                nombre = :nombre,
                apellido = :apellido,
                email = :email,
                usuario = :usuario";

        if (isset($data['imagen'])) {
            $queryEditar .= ", imagen = :imagen";
        }

        $queryEditar .= " WHERE id = :id";

        $stmt2 = $db->prepare($queryEditar);
        $stmt2->execute($data);

        if (!$stmt2->execute($data)) {
            return false;
        }
        return true;
    }

    /**
     * Elimina un usuario por su $id.
     * Retorna true en caso de éxito, false de lo contrario.
     *
     * @param $id
     * @return bool
     */
    public function eliminar($id): bool
    {
        $db = DBConnection::getConnection();

        $query = " DELETE FROM usuarios
                WHERE id = ?";
        $stmt = $db->prepare($query);
        if (!$stmt->execute([$id])) {
            //throw new \Exception("No se pudo eliminar el usuario.");
            return false;
        }
        return true;
    }

    /**
     * Retorna el usuario al que pertenece el $email.
     *
     * @param string $email
     * @return Usuario
     * @throws QueryException
     */
    public function getByEmail(string $email)
    {
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM usuarios
                    WHERE email = ?";
        try {
            $stmt = $db->prepare($query);
            $stmt->execute([$email]);
        } catch (PDOException $e) {
            throw new QueryException($query, [$email], $stmt->errorInfo(), $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
        return $stmt->fetchObject(static::class);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param string $apellido
     */
    public function setApellido($apellido): void
    {
        $this->apellido = $apellido;
    }

    /**
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param string $imagen
     */
    public function setImagen($imagen): void
    {
        $this->imagen = $imagen;
    }

    /**
     * Esta función debe retornar cómo se representa como JSON este objeto.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'            => $this->getId(),
            'usuario'       => $this->getUsuario(),
            'email'         => $this->getEmail(),
            'nombre'        => $this->getNombre(),
            'apellido'      => $this->getApellido(),
            'imagen'        => $this->getImagen(),
        ];
    }

    /**
     * Chequea si ya existe una fila con un usuarios_id y republicaciones_id determinados.
     *
     * @param mixed $usuarios_id
     * @param mixed $publicaciones_id
     * @return boolean
     * @throws QueryException
     */
    public function verSiExiste($email)
    {
        $db = DBConnection::getConnection();
        $query = "SELECT * FROM usuarios
                WHERE email = ? ";

        try {
            $stmt = $db->prepare($query);
            $stmt->execute([$email]);
        } catch (PDOException $e) {
            throw new QueryException($query, [$email], $stmt->errorInfo(), $e->getMessage(), $e->getCode(), $e->getPrevious());
        }
        if ($stmt->fetchObject(static::class)) {
            return true; // ya existe la fila
        } else {
            return false; // no existe
        }
    }
}
