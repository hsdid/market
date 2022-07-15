<?php
declare(strict_types=1);

namespace App\Infrastructure\Company\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CompanyPhotoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
