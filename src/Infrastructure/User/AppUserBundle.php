<?php
declare(strict_types=1);
namespace App\Infrastructure\User;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppUserBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass($this->buildMappingCompilerPass());
    }

    public function buildMappingCompilerPass(): CompilerPassInterface
    {
        return DoctrineOrmMappingsPass::createYamlMappingDriver(
            [__DIR__.'/Entity/' => 'App\Domain\User'],
            [],
            false,
            ['AppUser' => 'App\Domain\User']
        );
    }
}
