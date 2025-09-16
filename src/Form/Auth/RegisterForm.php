<?php

namespace App\Form\Auth;

use App\Form\AbstractForm;
use App\Form\Auth\Types\ProfileType;
use App\Form\Auth\Types\UserType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterForm extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('user', UserType::class);
        $builder->add('profile', ProfileType::class);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function ($event) {
            if ($event->getForm()->isValid()) {
                $user = $event->getData()["user"];
                $profile = $event->getData()["profile"];

                $profile->setUser($user);
            }
        });
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'csrf_protection' => false
        ]);
    }
}
