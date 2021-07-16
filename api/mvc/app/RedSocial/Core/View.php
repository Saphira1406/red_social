<?php

namespace RedSocial\Core;

class View
{
    /**
     * Retorna la $data con formato JSON.
     *
     * @param mixed $data
     */
    public static function renderJson($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_FORCE_OBJECT);
    }
}

