<?php

namespace App\Infrastructure\User\ParamConverter;

use App\Domain\Core\Id\UserId;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\User\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserParamConverter implements ParamConverterInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $name = $configuration->getName();
        if (null === $request->attributes->get($name, false)) {
            $configuration->setIsOptional(true);
        }
        $value = $request->attributes->get($name);
        $object = $this->userRepository->find(new UserId($value));

        $notFoundEx = new NotFoundHttpException((sprintf('%s object not found.', $configuration->getClass())));

        if ((!$object instanceof User) && false === $configuration->isOptional()) {
            throw $notFoundEx;
        }

        $request->attributes->set($name, $object);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === User::class;
    }
}
