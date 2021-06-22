<?php

namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use JsonSerializable;
use PDO;

class Publicacion extends Modelo implements JsonSerializable
{
    private $id;
    private $usuarios_id;
    private $texto;
    private $imagen;

    /**
     * Esta función debe retornar cómo se representa como JSON este objeto.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'           => $this->getId(),
            'usuarios_id'   => $this->getIdUsuario(),
            'texto'        => $this->getTexto(),
            'imagen'                => $this->getImagen(),
        ];
    }

    /**
     * Retorna todos las publicaciones de la base de datos.
     *
     * @return array|Publicacion[]
     */
    public function traerTodo(): array
    {
        // Pedimos la conexión a la clase DBConnection...
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM publicaciones";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $salida = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //            $salida[] = $fila;
            // En cada vuelta, instanciamos una publicación para almacenar los datos del registro.
            $publicacion = new self();
            $publicacion->setId($fila['id']);
            $publicacion->setIdUsuario($fila['usuarios_id']);
            $publicacion->setTexto($fila['texto']);
            $publicacion->setImagen($fila['imagen']);

            $salida[] = $publicacion;
        }

        return $salida;
    }

    /**
     * Retorna una publicación por su PK.
     * Si no existe, retorna null.
     *
     * @param int $id
     * @return Producto|null
     */
    public function traerPorPK($id)
    {
        $db = DBConnection::getConnection();
        $query = "SELECT * FROM publicaciones
                WHERE id = ?";
        $stmt = $db->prepare($query);
        if (!$stmt->execute([$id])) {
            //            throw new \Exception('No existe una publicación con este id.');
            return null;
        }

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        $publicacion = new self();
        $publicacion->setId($fila['id']);
        $publicacion->setIdUsuario($fila['usuarios_id']);
        $publicacion->setTexto($fila['texto']);
        $publicacion->setImagen($fila['imagen']);
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
        $query = "INSERT INTO publicaciones (usuarios_id, texto) 
                  VALUES (:usuarios_id, :texto)";
        $stmt = $db->prepare($query);

        //        return $stmt->execute($data);

        if (!$stmt->execute($data)) {
            return false;
        }
        return true;
    }

    public function editar()
    {
        $db = DBConnection::getConnection();
    }

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
            //            throw new \Exception("No se pudo eliminar el producto #" . $id);
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
    public function getIdUsuario()
    {
        return $this->usuarios_id;
    }

    /**
     * @param mixed $usuarios_id
     */
    public function setIdUsuario($usuarios_id)
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
}
