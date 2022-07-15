<?php

namespace App\Infrastructure\Company;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppCompanyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass($this->buildMappingCompilerPass());
    }
    public function buildMappingCompilerPass(): CompilerPassInterface
    {
        return DoctrineOrmMappingsPass::createYamlMappingDriver(
            [__DIR__.'/Persistence/Doctrine/ORM' => 'App\Domain\Company'],
            [],
            false,
            ['AppOffer' => 'App\Domain\Company']
        );
    }

}
