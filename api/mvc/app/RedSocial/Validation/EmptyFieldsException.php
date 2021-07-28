<?php

namespace RedSocial\Validation;

use Throwable;

class EmptyFieldsException extends \Exception
{
    /**
     * EmptyFieldsException constructor.
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message === "" ? "El array de campos para validar no puede estar vacío" : $message;
        parent::__construct($message, $code, $previous);
    }
}
