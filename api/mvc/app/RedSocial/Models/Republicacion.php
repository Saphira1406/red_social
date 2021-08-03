<?php

namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use RedSocial\DB\QueryException;
use JsonSerializable;
use PDO;
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

    // Propiedades para las clases de las tablas asociadas.
    /** @var Usuario */
    private $usuario;

    /** @var array|Comentario[] */
    private $comentarios = [];

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
            'usuario'       => $this->getUsuario(),
            'comentarios'   => $this->getComentarios()
        ];
    }

    /**
     * Retorna todas las republicaciones de un usuario desde la base de datos.
     *
     * @return array|Republicacion[]
     * @throws QueryException
     */
    public function traerTodo(): array
    {
        // Pedimos la conexión a la clase DBConnection...
        $db = DBConnection::getConnection();

        $query = "SELECT r.*, u.email, u.nombre, u.apellido, u.imagen FROM republicaciones r
                  INNER JOIN usuarios u ON r.usuarios_id = u.id ORDER BY r.id DESC";
        try {
            $stmt = $db->prepare($query);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new QueryException($query, [], $stmt->errorInfo(), $e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        $salida = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $publicacion = new self();

            $publicacion->cargarDatosDeArray($fila);

            $usuario = new Usuario();
            $usuario->cargarDatosDeArray([
                'id'       => $fila['usuarios_id'],
                'email'    => $fila['email'],
                'nombre'   => $fila['nombre'],
                'apellido' => $fila['apellido'],
                'imagen'   => $fila['imagen'],
                'fecha'    => $fila['fecha'],
            ]);

            $publicacion->setUsuario($usuario);

            $salida[] = $publicacion;
        }

        // Cargamos los comentarios de las publicaciones que vamos a retornar.
        $salida = $this->cargarComentariosEnLasPublicaciones($salida);

        return $salida;
    }

    /**
     * Carga los Comentarios en las $publicaciones provistas, y retorna un nuevo array con esos datos.
     *
     * @param array|Publicacion[] $publicaciones
     * @return array
     */
    public function cargarComentariosEnLasPublicaciones(array $publicaciones): array
    {
        $salida = [];
        $ids = [];

        foreach ($publicaciones as $publicacion) {
            $id = $publicacion->getId();
            $ids[] = $id;
            $salida[$id] = $publicacion;
        }

        // Con los ids en mano, hacemos el query para traer los comentarios.
        $comentariosTotales = (new Comentario())->traerPorListaDePublicaciones($ids);

        // Ahora, finalmente, asignamos cada comentario a la publicación que le corresponde.
        foreach ($comentariosTotales as $comentario) {
            $idPublicacion = $comentario->getPublicacionesId();
            $salida[$idPublicacion]->addComentario($comentario);
        }

        // Reseteamos las claves del array, para dejarlo tal cual nos lo entregaron.
        return array_values($salida);
    }

    /**
     * Trae los comentarios de la Publicación.
     */
    public function traerComentarios()
    {
        $this->comentarios = (new Comentario())->traerPorIdPublicacion($this->getId());
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
     * @return array|Comentario[]
     */
    public function getComentarios(): array
    {
        return $this->comentarios;
    }

    /**
     * @param array|Comentario[] $comentarios
     */
    public function setComentarios(array $comentarios): void
    {
        $this->comentarios = $comentarios;
    }

    /**
     * @param Comentario $comentario
     */
    public function addComentario(Comentario $comentario): void
    {
        $this->comentarios[] = $comentario;
    }
}
