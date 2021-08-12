<?php

namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use RedSocial\DB\QueryException;
use JsonSerializable;
use PDOException;

class Republicacion extends Modelo implements JsonSerializable
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = 'republicaciones';

    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [
        'id',
        'usuarios_id',
        'publicaciones_id',
    ];

    private $id;
    private $usuarios_id;
    private $publicaciones_id;

    /**
     * Esta función debe retornar cómo se representa como JSON este objeto.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'            => $this->getId(),
            'usuarios_id'   => $this->getUsuariosId(),
            'publicaciones_id' => $this->getPublicacionesId(),
        ];
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
    public function getUsuariosId()
    {
        return $this->usuarios_id;
    }

    /**
     * @param mixed $usuarios_id
     */
    public function setUsuariosId($usuarios_id)
    {
        $this->usuarios_id = $usuarios_id;
    }

    /**
     * @return mixed
     */
    public function getPublicacionesId()
    {
        return $this->publicaciones_id;
    }

    /**
     * @param mixed $publicaciones_id
     */
    public function setPublicacionesId($publicaciones_id)
    {
        $this->publicaciones_id = $publicaciones_id;
    }

    /**
     * Chequea si ya existe una fila con un usuarios_id y publicaciones_id determinados.
     *
     * @param mixed $usuarios_id
     * @param mixed $publicaciones_id
     * @return boolean
     * @throws QueryException
     */
    public function verSiExiste($publicaciones_id, $usuarios_id)
    {
        $db = DBConnection::getConnection();
        $query = "SELECT * FROM republicaciones
                WHERE publicaciones_id = ? AND usuarios_id = ?";

        $stmt = $db->prepare($query);

        if ($stmt->execute([$publicaciones_id, $usuarios_id])) {
            if ($stmt->fetchObject(static::class)) {
                return true; // ya existe la fila
            } else {
                return false; // no existe
            }
        } else {
            throw new QueryException($query, [$publicaciones_id, $usuarios_id], $stmt->errorInfo());
        }
    }
}
