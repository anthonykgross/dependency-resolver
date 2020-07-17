<?php declare(strict_types=1);

namespace Algorithm;

class ResolveBehaviour
{
    private $throwOnCircularReference = true;

    private $throwOnMissingReference = false;

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

    public function isThrowOnMissingReference(): bool
    {
        return $this->throwOnMissingReference;
    }

    public function setThrowOnMissingReference(bool $throwOnMissingReference): self
    {
        $this->throwOnMissingReference = $throwOnMissingReference;

        return $this;
    }
}
