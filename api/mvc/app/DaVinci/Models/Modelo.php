<?php

namespace DaVinci\Models;

/**
 * Class Modelo
 * Base de los modelos tipo ActiveRecord del sistema.
 * Ofrece todas las acciones básicas de un ABM (traer todos, traer por PK, crear, editar, eliminar)
 * a través de unas propiedades configurables.
 *
 * @package DaVinci\Models
 */
class Modelo
{
    /** @var string La tabla con la que el Modelo se mapea. */
    protected $table = '';

    /** @var string El nombre del campo que es la PK. */
    protected $primaryKey = 'id';

    /** @var array La lista de atributos/campos de la tabla que se mapean con las propiedades del Modelo. */
    protected $attributes = [];
}
