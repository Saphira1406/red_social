<?php


namespace RedSocial\Models;

use RedSocial\DB\DBConnection;
use JsonSerializable;
use PDO;

class Favoritos extends Modelo implements JsonSerializable
{
    protected $table = 'favoritos';

    protected $primaryKey = 'id';

    protected $attributes = [
        'id',
        'emisor_id',
        'receptor_id',
    ];

    private $id;
    private $emisor_id;
    private $receptor_id;

    private $usuario;

    public function jsonSerialize()
    {
        return [
            'id'            => $this->getId(),
            'emisor_id'     => $this->getEmisorId(),
            'receptor_id'   => $this->getReceptorId(),
            'receptor'      => $this->getUsuario(),
        ];
    }

    public function traerTodos($id): array
    {
        // Pedimos la conexión a la clase DBConnection...
        $db = DBConnection::getConnection();

        $query = "SELECT f.*, p.imagen, p.texto, p.fecha FROM favoritos f INNER JOIN publicaciones p ON a.receptor_id = p.id
                  WHERE emisor_id = ? ";

        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        $salida = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favorito = new self();

            $favorito->cargarDatosDeArray($fila);

            $receptor = new Usuario();
            $receptor->cargarDatosDeArray([

                'texto'   => $fila['texto'],
                'fecha' => $fila['fecha'],
                'imagen'   => $fila['imagen'],
            ]);

            $favorito->setUsuario($receptor);

            $salida[] = $favorito;
        }

        return $salida;
    }
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
     * Crea una nuevo favorito en la base de datos.
     *
     * @param array $data
     * @return bool
     */
     public function crear(array $data): bool
     {
         $db = DBConnection::getConnection();
         $query = "INSERT INTO favoritos (emisor_id, receptor_id)
                   VALUES (:emisor_id, :receptor_id)";
         $stmt = $db->prepare($query);

         if (!$stmt->execute($data)) {
             return false;
         }
         return true;
     }
    /*
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
         }*/

    public function getByPk(int $pk)
    {
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM favoritos
                    WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$pk]);

        // Si no podemos obtener la fila, retornamos null.
        if (!$fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return null;
        }

        $favorito= new Favoritos;
        $favorito->id = $fila['id'];
        $favorito->emisor_id = $fila['emisor_id'];
        $favorito->receptor_id = $fila['receptor_id'];

        return $favorito;
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