<?php

namespace Algorithm\Exception;

class CircularReferenceException extends \RuntimeException
{
    /**
     * @var int|string
     */
    private $item;

    /**
     * @var int|string
     */
    private $dependency;

    /**
     * @param int|string $item
     * @param int|string $dependency
     */
    public function __construct($item, $dependency, int $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf("Circular dependency: %s -> %s", $item, $dependency), $code, $previous);
        $this->item = $item;
        $this->dependency = $dependency;
    }

    /**
     * @return int|string
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @return int|string
     */
    public function getDependency()
    {
        return $this->dependency;
    }
}
