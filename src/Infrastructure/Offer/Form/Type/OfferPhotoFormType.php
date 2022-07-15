<?php
declare(strict_types=1);

namespace App\Infrastructure\Offer\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class OfferPhotoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'files',
            FileType::class,
            [
                'required' => true,
                'multiple' => true,
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
            ]
        );
    }
}
