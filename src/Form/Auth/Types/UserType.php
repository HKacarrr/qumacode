<?php

namespace App\Form\Auth\Types;

use App\Entity\User\User;
use Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->addEventListener(FormEvents::PRE_SUBMIT, function ($event) {
                $data = $event->getData();

                /** Password Checker */
                $passwordLength = strlen(@$data['password'] ?? '');
                if ($passwordLength < 6) {
                    throw new Exception("Password must be at least 8 characters long.");
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
        ]);
    }
}
