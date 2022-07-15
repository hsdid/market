<?php
declare(strict_types=1);

namespace App\Domain\Core\Search\Criteria;

class PaginationCriteria implements CriteriaInterface
{
    protected int $page;
    protected int $itemsPerPage;

    public function __construct(int $page, int $itemsPerPage)
    {
        $this->page = $page;
        $this->itemsPerPage = $itemsPerPage;
    }

    public function getName(): string
    {
        return 'pagination';
    }

    public function getOperator(): string
    {
        return '';
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }
}
