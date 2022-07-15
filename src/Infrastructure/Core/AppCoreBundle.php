<?php
declare(strict_types=1);

namespace App\Infrastructure\Core;

use App\Infrastructure\Core\DependencyInjection\Compiler\SearchCriteriaBuilderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppCoreBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new SearchCriteriaBuilderCompilerPass());
    }
}
