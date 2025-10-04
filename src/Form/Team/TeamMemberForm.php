<?php

namespace App\Form\Team;

use App\Entity\Team\Team;
use App\Entity\Team\TeamMember;
use App\Entity\Team\TeamMemberRole;
use App\Entity\User\User;
use App\Form\Common\TeamType;
use App\Form\Common\UserType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamMemberForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        TeamType::addToBuilder($builder, ['documentation' => false]);
        UserType::addToBuilder($builder, ['documentation' => false]);

        $builder
            ->add('active', CheckboxType::class, [
                'required' => false,
                'data' => true,
                'empty_data' => '1'
            ])
            ->add('teamMemberRole', EntityType::class, [
                'class' => TeamMemberRole::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeamMember::class,
            'csrf_protection' => false
        ]);
    }
}
