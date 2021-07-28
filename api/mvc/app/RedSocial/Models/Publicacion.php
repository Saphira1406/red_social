<?php

namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use RedSocial\DB\QueryException;
use JsonSerializable;
use PDO;
use PDOException;

class Publicacion extends Modelo implements JsonSerializable
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = 'publicaciones';

    /** @var string El nombre del campo que es la PK. */
    protected $primaryKey = 'id';

    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [
        'id',
        'usuarios_id',
        'texto',
        'imagen',
        'fecha',
    ];

    private $id;
    private $usuarios_id;
    private $texto;
    private $imagen;
    private $fecha;

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
            'texto'         => $this->getTexto(),
            'imagen'        => $this->getImagen(),
            'fecha'         => $this->getFecha(),
            'usuario'       => $this->getUsuario(),
            'comentarios'   => $this->getComentarios()
        ];
    }

    /**
     * Retorna todas las publicaciones de la base de datos.
     *
     * @return array|Publicacion[]
     */
    public function traerTodo(): array
    {
        // Pedimos la conexión a la clase DBConnection...
        $db = DBConnection::getConnection();

        $query = "SELECT p.*, u.email, u.nombre, u.apellido, u.imagen as img_perfil FROM publicaciones p
                  INNER JOIN usuarios u ON p.usuarios_id = u.id ORDER BY p.id DESC";
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
                'imagen'   => $fila['img_perfil'],
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
     * Retorna una publicación por su PK.
     * Si no existe, retorna null.
     *
     * @param int $id
     * @return Publicacion|null
     */
    public function traerPorPK($id)
    {
        $db = DBConnection::getConnection();
        $query = "SELECT * FROM publicaciones
                WHERE id = ?";
        $stmt = $db->prepare($query);
        if (!$stmt->execute([$id])) {
            return null;
        }

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        $publicacion = new self();
        $publicacion->setId($fila['id']);
        $publicacion->setUsuariosId($fila['usuarios_id']);
        $publicacion->setTexto($fila['texto']);
        $publicacion->setImagen($fila['imagen']);
        $publicacion->setFecha($fila['fecha']);
        return $publicacion;
    }

    /**
     * Crea una nueva publicación en la base de datos.
     *
     * @param array $data
     * @return bool
     */
    public function crear(array $data): bool
    {
        $db = DBConnection::getConnection();
        $query = "INSERT INTO publicaciones (usuarios_id, texto, imagen, fecha) 
                  VALUES (:usuarios_id, :texto, :imagen, :fecha)";
        $stmt = $db->prepare($query);

        if (!$stmt->execute($data)) {
            return false;
        }
        return true;
    }

    /*
    public function editar()
    {
        $db = DBConnection::getConnection();
    }
*/

    /**
     * Elimina una publicación por su $id.
     * Retorna true en caso de éxito, false de lo contrario.
     *
     * @param $id
     * @return bool
     */
    public function eliminar($id): bool
    {
        $db = DBConnection::getConnection();
        $query = "DELETE FROM publicaciones
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
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param mixed $texto
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;
    }

    /**
     * @return mixed
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
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
