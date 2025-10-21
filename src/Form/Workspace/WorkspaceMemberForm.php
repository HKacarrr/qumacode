<?php

namespace App\Form\Workspace;

use App\Entity\Workspace\WorkspaceMember;
use App\Entity\Workspace\WorkspaceMemberRole;
use App\Form\AbstractForm;
use App\Form\Common\UserType;
use App\Form\Common\WorkspaceType;
use Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkspaceMemberForm extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        WorkspaceType::addToBuilder($builder, ['documentation' => false]);
        UserType::addToBuilder($builder);

        $builder
            ->add('active')
            ->add('workspaceMemberRole', EntityType::class, [
                'class' => WorkspaceMemberRole::class,
                'choice_label' => 'id',
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function ($event) {
                $form = $event->getForm();
                $method = $form->getConfig()->getMethod();

                $user = $form->get('user')->getData();
                $workspace = $form->get('workspace')->getData();

                if ($method != 'PUT'){
                    $workspaceMember = $this->getEntityManager()->getRepository(WorkspaceMember::class)->findOneBy([
                        'user' => $user,
                        'workspace' => $workspace,
                    ]);

                    if ($workspaceMember){
                        throw new Exception("This user is already a member of the workspace.");
                    }
                }
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function ($event) {
                $form = $event->getForm();
                $method = $form->getConfig()->getMethod();

                if ($method == 'PUT') {
                    $workspaceMember = $form->getData(); // mevcut entity (eski)
                    $data = $event->getData(); // body’den gelen raw data
                    $userId = $data['user'] ?? null;

                    if ($workspaceMember->getUser()->getId() != $userId){
                        throw new Exception("Process is denied.");
                    }
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkspaceMember::class,
            'csrf_protection' => false,
        ]);
    }
}
