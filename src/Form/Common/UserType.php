<?php

namespace App\Form\Common;

use App\Entity\User\User;
use App\Entity\Workspace\Workspace;
use App\Form\AbstractForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractForm
{
    public static function addToBuilder(FormBuilderInterface $builder, array $options = []): FormBuilderInterface
    {
        $builder->add("user", null, $options);
        return $builder;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            "required" => false
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
