<?php
declare(strict_types=1);
namespace App\Infrastructure\User\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'firstName',
            TextType::class,
            [
                'label' => 'First name',
                'required' => true,
                'empty_data' => '',
            ]
        );
        $builder->add(
            'lastName',
            TextType::class,
            [
                'label' => 'Last name',
                'required' => true,
                'empty_data' => '',
            ]
        );
        $builder->add(
            'email',
            EmailType::class,
            [
                'label' => 'Email',
                'required' => true,
                'constraints' => [
                    new Email(),
                    new NotBlank(),
                ],
            ]
        );
        $builder->add(
            'createdAt',
            DateTimeType::class,
            [
                'label' => 'Creation date',
                'required' => false,
                'widget' => 'single_text',
                'format' => DateTimeType::HTML5_FORMAT,
            ]
        );

        $builder->add('password', PasswordType::class, [
            'required' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

}
