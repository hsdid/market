<?php

namespace App\Infrastructure\Offer\ParamConverter;

use App\Domain\Core\Id\OfferId;
use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OfferParamConverter implements ParamConverterInterface
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $name = $configuration->getName();
        if (null === $request->attributes->get($name, false)) {
            $configuration->setIsOptional(true);
        }
        $value = $request->attributes->get($name);
        $object = $this->offerRepository->getById(new OfferId($value));

        $notFoundEx = new NotFoundHttpException((sprintf('%s object not found.', $configuration->getClass())));

        if ((!$object instanceof Offer) && false === $configuration->isOptional()) {
            throw $notFoundEx;
        }

        $request->attributes->set($name, $object);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === Offer::class;
    }
}
