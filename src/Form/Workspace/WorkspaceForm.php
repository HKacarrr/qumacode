<?php

namespace App\Form\Workspace;

use App\Entity\Team\Team;
use App\Entity\User\User;
use App\Entity\Workspace\Workspace;
use App\Form\Common\TeamType;
use App\Form\Common\UserType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkspaceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        UserType::addToBuilder($builder, ['documentation' => false]);
        TeamType::addToBuilder($builder, ['documentation' => false]);

        $builder
            ->add('title')
            ->add('description')
            ->add('logo')
            ->add('email')
            ->add('phone')
            ->add('website')
            ->add('active', CheckboxType::class, [
                'required' => false,
                'data' => true,
                'empty_data' => '1'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workspace::class,
            'csrf_protection' => false
        ]);
    }
}
