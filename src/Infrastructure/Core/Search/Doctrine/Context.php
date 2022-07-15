<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Search\Doctrine;

use App\Domain\Core\Search\Context\ContextInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;


class Context implements ContextInterface
{
    private const NAME = 'doctrine';

    public const DEFAULT_ALIAS = 'obj';
    public const CLASS_PARAM = 'class';

    protected string $name;
    protected EntityManagerInterface $entityManager;
    protected array $params;
    protected ?QueryBuilder $queryBuilder = null;

    public function __construct(string $name, EntityManagerInterface $entityManager, array $params = [])
    {
        $this->name = $name;
        $this->entityManager = $entityManager;
        $this->params = $params;
    }

    //to-do sprawdz czemu return object
    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): object
    {
        if (null === $this->queryBuilder) {
            $this->queryBuilder = $this->createQueryBuilder();
        }

        return $this->queryBuilder;
    }

    public function getName(): string
    {
        return self::NAME.ContextInterface::CONTEXT_SEPARATOR.$this->name;
    }

    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        if (array_key_exists(self::CLASS_PARAM, $this->params)) {
            $queryBuilder
                ->from($this->params[self::CLASS_PARAM], self::DEFAULT_ALIAS);
        }

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getParam(string $name)
    {
        return array_key_exists($name, $this->params) ? $this->params[$name] : null;
    }
}
