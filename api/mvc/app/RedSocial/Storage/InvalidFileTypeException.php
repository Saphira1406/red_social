<?php

namespace RedSocial\Storage;

use Throwable;

/**
 * Class InvalidFileTypeException
 *
 * @package RedSocial\Storage
 */
class InvalidFileTypeException extends \Exception
{
    /** @var string */
    protected $fileType;

    /**
     * InvalidFileTypeException constructor.
     *
     * @param string $fileType
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $fileType, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->fileType = $fileType;
        if ($message === "") {
            $message = 'El tipo de archivo provisto no es válido. Debe ser un array o un string, se pasó un ' . $this->fileType;
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * The file type provided.
     *
     * @return string
     */
    public function getFileType(): string
    {
        return $this->fileType;
    }
}
