<?php
declare(strict_types=1);
namespace App\Infrastructure\Offer;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppOfferBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass($this->buildMappingCompilerPass());
    }

    public function buildMappingCompilerPass(): CompilerPassInterface
    {
        return DoctrineOrmMappingsPass::createYamlMappingDriver(
            [__DIR__.'/Persistence/Doctrine/ORM' => 'App\Domain\Offer'],
            [],
            false,
            ['AppOffer' => 'App\Domain\Offer']
        );
    }
}
