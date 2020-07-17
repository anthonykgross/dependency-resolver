<?php declare(strict_types=1);

namespace Algorithm\Exception;

abstract class ResolveException extends \RuntimeException
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
    public function __construct($item, $dependency, string $message, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
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
