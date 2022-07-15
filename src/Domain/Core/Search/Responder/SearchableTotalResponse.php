<?php

declare(strict_types=1);

namespace App\Domain\Core\Search\Responder;

class SearchableTotalResponse
{
    protected ?int $all;

    protected ?int $filtered;

    public function __construct(?int $all, ?int $filtered)
    {
        $this->all = $all;
        $this->filtered = $filtered;
    }

    public function getAll(): ?int
    {
        return $this->all;
    }

    public function getFiltered(): ?int
    {
        return $this->filtered;
    }
}
