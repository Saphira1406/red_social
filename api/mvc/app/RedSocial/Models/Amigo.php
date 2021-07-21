<?php

namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use JsonSerializable;
use PDO;

class Amigo extends Modelo implements JsonSerializable
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = 'amigos';

    /** @var string El nombre del campo que es la PK. */
    protected $primaryKey = 'id';

    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [
        'id',
        'emisor_id',
        'receptor_id',
    ];

    private $id;
    private $emisor_id;
    private $receptor_id;

    // Propiedades para las clases de las tablas asociadas.
    /** @var Usuario */
    private $usuario;

    /**
     * Esta función debe retornar cómo se representa como JSON este objeto.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'            => $this->getId(),
            'emisor_id'     => $this->getEmisorId(),
            'receptor_id'   => $this->getReceptorId(),
            'receptor'      => $this->getUsuario(),
        ];
    }

    /**
     * Retorna todos los amigos de un usuario
     *
     * @param int|$id
     * @return array|Amigo[]
     */
    public function traerTodos($id): array
    {
        // Pedimos la conexión a la clase DBConnection...
        $db = DBConnection::getConnection();

        $query = "SELECT a.*, u.nombre, u.apellido, u.imagen FROM amigos a INNER JOIN usuarios u ON a.receptor_id = u.id
                  WHERE emisor_id = ? ";

        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        $salida = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $amigo = new self();

            $amigo->cargarDatosDeArray($fila);

            $receptor = new Usuario();
            $receptor->cargarDatosDeArray([

                'nombre'   => $fila['nombre'],
                'apellido' => $fila['apellido'],
                'imagen'   => $fila['imagen'],
            ]);

            $amigo->setUsuario($receptor);

            $salida[] = $amigo;
        }

        return $salida;
    }

    /**
     * @return Usuario
     */
    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario(Usuario $usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * Crea una nueva amistad en la base de datos.
     *
     * @param array $data
     * @return bool
     */
    public function crear(array $data): bool
    {
        $db = DBConnection::getConnection();
        $query = "INSERT INTO amigos (emisor_id, receptor_id) 
                  VALUES (:emisor_id, :receptor_id)";
        $stmt = $db->prepare($query);

        if (!$stmt->execute($data)) {
            return false;
        }
        return true;
    }

    /**
     * Elimina un amigo por su $id.
     * Retorna true en caso de éxito, false de lo contrario.
     *
     * @param $id
     * @return bool
     */
    public function eliminar($id): bool
    {
        $db = DBConnection::getConnection();
        $query = "DELETE FROM amigos
                WHERE id = ?";
        $stmt = $db->prepare($query);
        if (!$stmt->execute([$id])) {
            return false;
        }
        return true;
    }

    /**
     * Retorna el amigo al que pertenece la $pk.
     * De no existir, retorna null.
     *
     * @param int $pk
     * @return Amigo|null
     */
    public function getByPk(int $pk)
    {
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM amigos
                    WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$pk]);

        // Si no podemos obtener la fila, retornamos null.
        if (!$fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return null;
        }

        $amigo = new Amigo;
        $amigo->id = $fila['id'];
        $amigo->emisor_id = $fila['emisor_id'];
        $amigo->receptor_id = $fila['receptor_id'];

        return $amigo;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmisorId()
    {
        return $this->emisor_id;
    }

    /**
     * @param mixed $emisor_id
     */
    public function setEmisorId($emisor_id)
    {
        $this->emisor_id = $emisor_id;
    }

    /**
     * @return mixed
     */
    public function getReceptorId()
    {
        return $this->receptor_id;
    }

    /**
     * @param mixed $receptor_id
     */
    public function setReceptorId($receptor_id)
    {
        $this->receptor_id = $receptor_id;
    }
}
