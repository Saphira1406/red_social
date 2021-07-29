<?php

namespace RedSocial\DB;

use Throwable;

class QueryException extends \PDOException
{
    /** @var string */
    protected $sql;

    /** @var array */
    protected $bindings = [];

    /** @var string */
    protected $sqlWithBindings;

    /**
     * QueryException constructor.
     *
     * @param string $sql               - El query que se ejecutó.
     * @param array $bindings           - Los valores que se asocian a cada holder.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $sql, array $bindings = [], array $errorInfo = [], $message = "", $code = 0, Throwable $previous = null)
    {
        $this->errorInfo = $errorInfo;
        $this->sql = $sql;
        $this->bindings = $bindings;
        $this->generateSqlWithBindings();
        parent::__construct($message, $code, $previous);
    }

    /**
     * Reemplaza los tokens de los holders con sus valores.
     */
    private function generateSqlWithBindings()
    {
        $this->sqlWithBindings = $this->sql;
        foreach ($this->bindings as $key => $value) {
            if (is_int($key)) {
                // TODO: Fix this to allow multiple ? tokens.
                $this->sqlWithBindings = str_replace('?', $value, $this->sqlWithBindings);
            } else {
                $value = !is_numeric($value) ? "'" . $value . "'" : $value;
                $this->sqlWithBindings = str_replace(':' . $key, $value, $this->sqlWithBindings);
            }
        }
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * @return array
     */
    public function getBindings(): array
    {
        return $this->bindings;
    }

    /**
     * @return string
     */
    public function getSqlWithBindings(): string
    {
        return $this->sqlWithBindings;
    }

    /**
     * @return array
     */
    public function getErrorInfo(): array
    {
        return $this->errorInfo;
    }
}
