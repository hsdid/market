<?php
declare(strict_types=1);

namespace App\Domain\Core\Search\Responder;

class SearchableResponse
{
    /**
     * @var object[]
     */
    protected array $items;

    protected SearchableTotalResponse $total;

    public function __construct(array $items, ?int $totalAll, ?int $totalFiltered)
    {
        $this->items = $items;
        $this->total = new SearchableTotalResponse($totalAll, $totalFiltered);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): SearchableTotalResponse
    {
        return $this->total;
    }
}
