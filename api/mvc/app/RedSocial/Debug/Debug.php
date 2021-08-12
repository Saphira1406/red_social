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
        if (App::getEnv('DEBUG') == "true") {
            return ("Error en la ejecución del query: " . implode(' - ', $e->getErrorInfo()) . " 
            Query con bindings reemplazados: " . $e->getSqlWithBindings() . " 
            Query: " . $e->getSql() . " 
            Bindings: [" . implode(', ', $e->getBindings()) . "]");
        } else {
            return null;
        }
    }
}
