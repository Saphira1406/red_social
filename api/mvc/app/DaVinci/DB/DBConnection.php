<?php
/*
 * Esta clase va a servir como un wrapper (envoltorio) de PDO en modo "singleton".
 * Singleton es un patrón de diseño con una premisa muy simple:
 *  Una clase es un singleton si solo puede existir una única instancia de la misma en el sistema.
 *
 * Por lo tanto, si muchos lugares distintos del código necesitan usar esa clase, siempre van a recibir
 * todos la misma exacta instancia.
 * Esto es muy útil para cosas como la conexión a la base de datos. Donde quiero que todos los que
 * tengan que interactuar contra la base usen la misma conexión, sin tener que preocuparse de cómo
 * se obtiene o se crea la misma.
 *
 * ¿Cómo logramos que una clase solo pueda instanciarse una única vez?
 * Si queremos asegurarnos de que no pueda haber una X cantidad de instancias, necesitamos una suerte
 * de "control de natalidad": Un constructor privado (o al menos, protected).
 *
 * ¿Cómo guardamos la instancia para que persista durante todo el programa y los demás puedan usarla?
 * Esto lo resolvemos usando una propiedad estática para guarda la instancia en cuestión.
 * Como vimos, las propiedades estáticas son únicas para la clase. Y dura toda la vida de la clase.
 *
 * Y finalmente, ¿Cómo hacemos para instanciar la clase si su constructor es privado?
 * Que el constructor sea privado, implica que solo puedo instanciar la clase desde dentro de la propia
 * clase.
 * En este caso, no nos interesa instanciar DBConnection en sí. Simplemente funciona como un
 * intermediario para tener una única instancia de PDO.
 * Pero si quisiera instanciarla, lo haría de una forma similar a lo que vamos a usar para crear el
 * PDO: un método static.
 */

namespace DaVinci\DB;

use Exception;
use PDO;

/**
 * Class DBConnection
 *
 * Wrapper tipo singleton para PDO.
 */
class DBConnection
{
    /** @var PDO|null Variable estática para guardar la conexión de PDO. */
    private static $db;

    // Constantes de conexión.
    const DB_HOST = "localhost";
    const DB_USER = "root";
    const DB_PASS = "root";
    const DB_BASE = "red_social";

    /**
     * DBConnection constructor.
     * Este constructor lo tenemos solo para marcarlo como privado, y evitar que se pueda instanciar
     * libremente la clase.
     */
    private function __construct()
    {
    }

    /**
     * Abre la conexión a la base instanciando PDO.
     */
    protected static function openConnection()
    {
        $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_BASE . ";charset=utf8mb4";

        try {
            self::$db = new PDO($dsn, self::DB_USER, self::DB_PASS);
        } catch (Exception $e) {
            echo "Error al conectar con la base de datos :(";
        }
    }

    /**
     * Retorna la conexión PDO a la base de datos.
     * Se encarga de siempre retornar la misma exacta conexión para todos.
     * Si no está aún abierta, primero hace la conexión, y luego la retorna.
     *
     * @return PDO
     */
    public static function getConnection()
    {
        // Primero, preguntamos si la conexión ya está creada, y sino, la creamos.
        // self hace referencia a la clase en la que estoy actualmente.
        if (self::$db === null) {
            self::openConnection();
        }

        return self::$db;
    }
}
