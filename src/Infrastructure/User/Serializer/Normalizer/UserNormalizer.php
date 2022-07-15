<?php
declare(strict_types=1);

namespace App\Infrastructure\User\Serializer\Normalizer;

use App\Domain\User\UserInterface;
use App\Infrastructure\User\Entity\User;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserNormalizer implements NormalizableInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $context['ignored_attributes'] = ['password', 'roles', 'salt'];

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof UserInterface;
    }
}