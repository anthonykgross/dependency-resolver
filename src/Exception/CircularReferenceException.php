<?php declare(strict_types=1);

namespace Algorithm\Exception;

class CircularReferenceException extends ResolveException
{
    /**
     * @param int|string $item
     * @param int|string $dependency
     */
    public function __construct($item, $dependency, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($item, $dependency, sprintf('Circular dependency: %s -> %s', $item, $dependency), $code, $previous);
    }
}
