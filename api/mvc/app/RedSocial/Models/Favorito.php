<?php


namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use JsonSerializable;
use PDO;

class Favorito extends Modelo implements JsonSerializable
{
    protected $table = 'favoritos';

    protected $attributes = [
        'id',
        'usuarios_id',
        'publicaciones_id',
    ];

    private $id;
    private $usuarios_id;
    private $publicaciones_id;

    private $publicacion;

    public function jsonSerialize()
    {
        return [
            'id'            => $this->getId(),
            'usuarios_id'     => $this->getUsuariosId(),
            'publicaciones_id'   => $this->getPublicacionesId(),
            'publicacion'      => $this->getPublicacion(),
        ];
    }

    public function traerTodos($id): array
    {
        // Pedimos la conexión a la clase DBConnection...
        $db = DBConnection::getConnection();

        $query = "SELECT f.*, p.imagen, p.texto, p.fecha, p.usuarios_id FROM favoritos f INNER JOIN publicaciones p ON f.publicaciones_id = p.id
                  WHERE f.usuarios_id = ? ";

        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        $salida = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favorito = new self();

            $favorito->cargarDatosDeArray($fila);

            $publicacion = new Publicacion();
            $publicacion->cargarDatosDeArray([
                'texto'   => $fila['texto'],
                'fecha' => $fila['fecha'],
                'imagen'   => $fila['imagen'],
            ]);

            $data = new Usuario();

            $favorito->setPublicacion($publicacion);

            $publicacion->setUsuario($data->traerPorPK($id));

            $salida[] = $favorito;
        }

        return $salida;
    }
    public function getPublicacion(): Publicacion
    {
        return $this->publicacion;
    }

    /**
     * @param Publicacion $publicacion
     */
    public function setPublicacion(Publicacion $publicacion): void
    {
        $this->publicacion = $publicacion;
    }

    public function eliminar($id): bool
    {
        $db = DBConnection::getConnection();
        $query = "DELETE FROM favoritos
                     WHERE id = ?";
        $stmt = $db->prepare($query);
        if (!$stmt->execute([$id])) {
            return false;
        }
        return true;
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
}
