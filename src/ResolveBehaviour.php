<?php declare(strict_types=1);

namespace Algorithm;

class ResolveBehaviour
{
    private $throwOnCircularReference = true;

    public static function create(): self
    {
        return new self();
    }

    public function isThrowOnCircularReference(): bool
    {
        return $this->throwOnCircularReference;
    }

    public function setThrowOnCircularReference(bool $throwOnCircularReference): self
    {
        $this->throwOnCircularReference = $throwOnCircularReference;

        return $this;
    }
}
