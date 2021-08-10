<?php

namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use JsonSerializable;
use PDO;

class Amigo extends Modelo implements JsonSerializable
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = 'amigos';

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
