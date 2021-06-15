<?php

namespace DaVinci\Models;

use DaVinci\DB\DBConnection;
use JsonSerializable;
use PDO;

class Publicacion extends Modelo implements JsonSerializable
{
    private $id;
    private $id_usuario;
    private $texto;

    /**
     * Esta función debe retornar cómo se representa como JSON este objeto.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'           => $this->getId(),
            'id_usuario'   => $this->getIdUsuario(),
            'texto'        => $this->getTexto(),
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
            $prod = new self();
            $prod->setId($fila['id']);
            $prod->setIdUsuario($fila['id_usuario']);
            $prod->setTexto($fila['texto']);

            $salida[] = $prod;
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

        $prod = new self();
        $prod->setId($fila['id']);
        $prod->setIdUsuario($fila['id_usuario']);
        $prod->setTexto($fila['texto']);
        return $prod;
    }

    /**
     * Crea un nuevo producto en la base de datos.
     *
     * @param array $data
     * @return bool
     */
    public function crear(array $data): bool
    {
        $db = DBConnection::getConnection();
        $query = "INSERT INTO publicaciones (id_usuario, texto) 
                  VALUES (:id_usuario, :texto)";
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
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
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
}
