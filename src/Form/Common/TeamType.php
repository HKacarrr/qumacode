<?php

namespace App\Form\Common;

use App\Entity\Team\Team;
use App\Form\AbstractForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractForm
{
    public static function addToBuilder(FormBuilderInterface $builder, array $options = []): FormBuilderInterface
    {
        $builder->add("team", null, $options);
        return $builder;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
            "required" => false
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}
