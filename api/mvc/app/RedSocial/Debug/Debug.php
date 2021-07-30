<?php

namespace RedSocial\Debug;

use RedSocial\Core\App;

class Debug
{
    /**
     * Imprime la data de un query, si el modo de DEBUG está habilitado.
     *
     * @param \RedSocial\DB\QueryException $e
     */
    public static function printQueryException(\RedSocial\DB\QueryException $e)
    {
        if (App::getEnv('DEBUG')) {
            echo "Error en la ejecución del query: " . implode(' - ', $e->getErrorInfo()) . "<br>";
            echo "Query con bindings reemplazados: " . $e->getSqlWithBindings() . "<br>";
            echo "Query: " . $e->getSql() . "<br>";
            echo "Bindings: [" . implode(', ', $e->getBindings()) . "]<br>";
        }
    }
}
