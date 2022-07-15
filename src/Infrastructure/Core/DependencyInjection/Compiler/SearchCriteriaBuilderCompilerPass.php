<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\DependencyInjection\Compiler;

use App\Domain\Core\Search\CriteriaBuilderProviderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SearchCriteriaBuilderCompilerPass implements CompilerPassInterface
{
    private const TAG_NAME = 'search.criteria.builder';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(CriteriaBuilderProviderInterface::class)) {
            return;
        }

        $criteriaProvider = $container->findDefinition(CriteriaBuilderProviderInterface::class);
        $criteriaBuilderServices = $container->findTaggedServiceIds(self::TAG_NAME);

        foreach ($criteriaBuilderServices as $id => $tags) {
            foreach ($tags as $tag) {
                $criteriaProvider->addMethodCall('addCriteriaBuilder', [$tag['context'], new Reference($id)]);
            }
        }
    }
}
