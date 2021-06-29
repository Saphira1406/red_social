<?php

namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use JsonSerializable;
use PDO;

class Comentario extends Modelo implements JsonSerializable
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = 'comentarios';

    /** @var string El nombre del campo que es la PK. */
    protected $primaryKey = 'id';

    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [
        'id',
        'usuarios_id',
        'texto',
        'publicaciones_id',
    ];


    private $publicaciones_id;
    private $id;          // id del comentario
    private $usuarios_id;
    private $texto;

    // Propiedades para las clases de las tablas asociadas.
    /** @var Usuario */
    private $usuario;

    // Propiedades para las clases de las tablas asociadas.
    /** @var Publicacion */
    private $publicacion;

    /**
     * @param array $data
     */
    /*
    public function cargarDatosDeArray(array $data)
    {
        $this->setId($data['id']);
        $this->setUsuariosId($data['usuarios_id']);
        $this->setTexto($data['texto']);
    }
*/
    /**
     * Esta función debe retornar cómo se representa como JSON este objeto.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'                => $this->getId(),
            'publicaciones_id'  => $this->getPublicacionesId(),
            'usuarios_id'       => $this->getUsuariosId(),
            'texto'             => $this->getTexto(),
            'usuario'           => $this->getUsuario(),
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
            "SELECT c.*, u.email, u.nombre, u.apellido, u.imagen AS img_perfil FROM comentarios c INNER JOIN usuarios u ON c.usuarios_id = u.id WHERE publicaciones_id IN (" . implode(',', $holders) . ")";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute($ids);

        $salida = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //            $salida[] = $fila;
            // En cada vuelta, instanciamos un comentario para almacenar los datos del registro.

            $comentario = new self();

            $comentario->cargarDatosDeArray($fila);

            $usuario = new Usuario();
            $usuario->cargarDatosDeArray([
                'id'       => $fila['usuarios_id'],
                'email'    => $fila['email'],
                'nombre'   => $fila['nombre'],
                'apellido' => $fila['apellido'],
                'imagen'   => $fila['img_perfil'],
            ]);

            $comentario->setUsuario($usuario);

            $salida[] = $comentario;
        }

        return $salida;

        // $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        // return $stmt->fetchAll();
    }

    /**
     * Crea un nuevo comentario en la base de datos.
     *
     * @param array $data
     * @return bool
     */
    public function crear(array $data): bool
    {
        $db = DBConnection::getConnection();
        $query = "INSERT INTO comentarios (usuarios_id, texto, publicaciones_id) 
                  VALUES (:usuarios_id, :texto, :publicaciones_id)";
        $stmt = $db->prepare($query);

        //        return $stmt->execute($data);

        if (!$stmt->execute($data)) {
            return false;
        }
        return true;
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
    public function getUsuariosId(): string
    {
        return $this->usuarios_id;
    }

    /**
     * @param string $usuarios_id
     */
    public function setUsuariosId(string $usuarios_id): void
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
    public function getPublicacionesId(): int
    {
        return $this->publicaciones_id;
    }

    /**
     * @param int $publicaciones_id
     */
    public function setPublicacionesId(int $publicaciones_id): void
    {
        $this->publicaciones_id = $publicaciones_id;
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
}
