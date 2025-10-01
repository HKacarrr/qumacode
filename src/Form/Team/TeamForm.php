<?php

namespace App\Form\Team;

use App\Entity\Team\Team;
use App\Entity\User\User;
use App\Form\Common\UserType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Uid\Uuid;

class TeamForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        UserType::addToBuilder($builder, ['documentation' => false]);
        $builder
            ->add('title')
            ->add('description')
            ->add('logo')
            ->add('uuid')
            ->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event){
                $data = $event->getData();
                $form = $event->getForm();
                $method = $form->getConfig()->getMethod();

                /** If process is update, we generate a new UUID value else we protect old UUID value for team */
                if ($method != 'PUT'){
                    $data['uuid'] = Uuid::v4();
                }else {
                    $team = $form->getData();
                    $data['uuid'] = $team->getUuid();
                }

                $event->setData($data);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
            'csrf_protection' => false,
        ]);
    }
}
