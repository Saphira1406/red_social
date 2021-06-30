<?php

namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use JsonSerializable;
use PDO;

class Usuario extends Modelo implements JsonSerializable
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = 'usuarios';

    /** @var string El nombre del campo que es la PK. */
    protected $primaryKey = 'id';

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

    /**
     * Crea un nuevo usuario en la base de datos.
     *
     * @param array $data
     * @return bool
     */

    public function crear(array $data): bool
    {
        $db = DBConnection::getConnection();

        $query = "INSERT INTO usuarios (nombre, apellido, email, password) 
                  VALUES (:nombre, :apellido, :email, :password)";

        $stmt = $db->prepare($query);

        if (!$stmt->execute($data)) {
            return false;
        }
        return true;
    }

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
                imagen = :imagen,
                usuario = :usuario";

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
            //            throw new \Exception("No se pudo eliminar el producto #" . $id);
            return false;
        }
        return true;
    }

    /**
     * Retorna el usuario al que pertenece el $email.
     * Si no existe, retorna null.
     *
     * @param string $email
     * @return Usuario|null
     */
    public function getByEmail(string $email)
    {
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM usuarios
                    WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);

        // Si no podemos obtener la fila, retornamos null.
        if (!$fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return null;
        }

        $usuario = new Usuario;
        $usuario->id = $fila['id'];
        $usuario->usuario = $fila['usuario'];
        $usuario->password = $fila['password'];
        $usuario->imagen = $fila['imagen'];
        $usuario->email = $email;
        $usuario->nombre = $fila['nombre'];
        $usuario->apellido = $fila['apellido'];


        return $usuario;
    }

    /**
     * Retorna el usuario al que pertenece la $pk.
     * De no existir, retorna null.
     *
     * @param int $pk
     * @return Usuario|null
     */
    public function getByPk(int $pk)
    {
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM usuarios
                    WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$pk]);

        // Si no podemos obtener la fila, retornamos null.
        if (!$fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return null;
        }

        $usuario = new Usuario;
        $usuario->id = $fila['id'];
        $usuario->usuario = $fila['usuario'];
        $usuario->password = $fila['password'];
        $usuario->email = $fila['email'];
        $usuario->imagen = $fila['imagen'];
        $usuario->nombre = $fila['nombre'];
        $usuario->apellido = $fila['apellido'];

        return $usuario;
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
}
