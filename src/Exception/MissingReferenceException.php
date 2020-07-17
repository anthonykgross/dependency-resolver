<?php declare(strict_types=1);

namespace Algorithm\Exception;

class MissingReferenceException extends ResolveException
{
    /**
     * @param int|string $item
     * @param int|string $dependency
     */
    public function __construct($item, $dependency, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($item, $dependency, sprintf('Missing dependency: %s -> %s', $item, $dependency), $code, $previous);
    }
}
