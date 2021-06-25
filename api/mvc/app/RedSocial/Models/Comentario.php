<?php

namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use JsonSerializable;
use PDO;

class Comentario implements JsonSerializable
{
    /** @var int */
    protected $publicaciones_id;
    /** @var int */
    protected $id;          // id del comentario
    /** @var string */
    protected $usuarios_id;
    /** @var string */
    protected $texto;

    /**
     * @param array $data
     */
    public function cargarDatosDeArray(array $data)
    {
        $this->setId($data['id']);
        $this->setIdUsuario($data['usuarios_id']);
        $this->setTexto($data['texto']);
    }

    /**
     * Esta función debe retornar cómo se representa como JSON este objeto.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'                => $this->getId(),
            'publicaciones_id'  => $this->getIdPublicacion(),
            'usuarios_id'       => $this->getIdUsuario(),
            'texto'             => $this->getTexto(),

        ];
    }

    /**
     * Retorna todos los comentarios de la publicación indicada.
     *
     * @param int $id
     * @return array|Comentario[]
     */
    public function traerPorIdPublicacion(int $id)
    {
        $query = "SELECT * FROM comentarios WHERE publicaciones_id = ?";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetchAll();
    }

    /**
     * Retorna los comentarios de las publicaciones cuyos ids figuren en el array provisto.
     *
     * @param array|int[] $ids
     * @return array|self[]
     */
    public function traerPorListaDePublicaciones(array $ids): array
    {
        // $ids = [1, 2, 3, 27]
        $holders = array_fill(0, count($ids), '?');
        $query =
            "SELECT * FROM comentarios WHERE publicaciones_id IN (" . implode(',', $holders) . ")";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute($ids);

        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetchAll();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIdUsuario(): string
    {
        return $this->usuarios_id;
    }

    /**
     * @param string $usuarios_id
     */
    public function setIdUsuario(string $usuarios_id): void
    {
        $this->usuarios_id = $usuarios_id;
    }

    /**
     * @return string
     */
    public function getTexto(): string
    {
        return $this->texto;
    }

    /**
     * @param string $texto
     */
    public function setTexto(string $texto): void
    {
        $this->texto = $texto;
    }

    /**
     * @return int
     */
    public function getIdPublicacion(): int
    {
        return $this->publicaciones_id;
    }

    /**
     * @param int $publicaciones_id
     */
    public function setIdPublicacion(int $publicaciones_id): void
    {
        $this->publicaciones_id = $publicaciones_id;
    }
}
