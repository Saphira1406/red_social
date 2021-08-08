<?php


namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use JsonSerializable;
use PDO;

class Favorito extends Modelo implements JsonSerializable
{
    /**
     * @var string La tabla con la que el Modelo se mapea.
     */
    protected $table = 'favoritos';

    /**
     * @var array[] La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo.
     */
    protected $attributes = [
        'id',
        'usuarios_id',
        'publicaciones_id',
    ];


    /** @var id */
    private $id;
    /** @var usuarios_id */
    private $usuarios_id;
    /** @var publicaciones_id */
    private $publicaciones_id;

    // Propiedades para las clases de las tablas asociadas.
    /** @var Publicacion */
    private $publicacion;

    /**
     * Esta función debe retornar cómo se representa como JSON este objeto.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'            => $this->getId(),
            'usuarios_id'     => $this->getUsuariosId(),
            'publicaciones_id'   => $this->getPublicacionesId(),
            'publicacion'      => $this->getPublicacion(),
        ];
    }

    /**
     * Retorna todos los favoritos de un usuario
     *
     * @param $id
     * @return array|Favorito[]
     */
    public function traerTodos($id): array
    {
        // Pedimos la conexión a la clase DBConnection...
        $db = DBConnection::getConnection();

        $query = "SELECT f.*, p.imagen, p.texto, p.fecha, p.usuarios_id AS u_id, usuarios.nombre, usuarios.apellido, usuarios.imagen AS img_perfil FROM favoritos AS f 
                INNER JOIN publicaciones AS p ON f.publicaciones_id = p.id
                INNER JOIN usuarios ON p.usuarios_id = usuarios.id
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
                'usuarios_id'   => $fila['u_id'],
            ]);

            $usuario = new Usuario();
            $usuario->cargarDatosDeArray([
                'id'       => $fila['u_id'],
                'nombre'   => $fila['nombre'],
                'apellido' => $fila['apellido'],
                'imagen'   => $fila['img_perfil'],
            ]);

            $publicacion->setUsuario($usuario);


            //$data = new Usuario();

            $favorito->setPublicacion($publicacion);

            //$publicacion->setUsuario($data->traerPorPK($id));


            $salida[] = $favorito;
        }
        return $salida;
    }

    /**
     * @return Publicacion
     */
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

    /**
     * Elimina un favorito por su $id.
     * Retorna true en caso de éxito, false de lo contrario.
     *
     * @param $id
     * @return bool
     */
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
