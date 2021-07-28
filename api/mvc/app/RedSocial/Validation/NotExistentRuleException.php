<?php

namespace RedSocial\Validation;

use Throwable;

class NotExistentRuleException extends \Exception
{
    /** @var string */
    protected $ruleName;

    /**
     * NotExistentRuleException constructor.
     *
     * @param string $ruleName
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $ruleName, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->ruleName = $ruleName;
        $message = $message !== "" ? 'No existe una validación llamada ' . $this->ruleName : $message;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getRuleName(): string
    {
        return $this->ruleName;
    }
}
