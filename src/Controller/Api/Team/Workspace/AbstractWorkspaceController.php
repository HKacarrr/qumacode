<?php

namespace App\Controller\Api\Team\Workspace;

use App\Controller\Api\Team\AbstractTeamController;
use App\Controller\Api\Team\Workspace\traits\AbstractWorkspaceControllerPrivateFunctionProviderTrait;
use App\Entity\Workspace\Workspace;
use App\Entity\Workspace\WorkspaceMember;
use App\Repository\Workspace\WorkspaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class AbstractWorkspaceController extends AbstractTeamController
{
    use AbstractWorkspaceControllerPrivateFunctionProviderTrait;

    private ?Workspace $workspace = null;
    private ?string $requestMethod = null;
    private ?EntityManagerInterface $em = null;

    public function __construct(RequestStack $request, Security $security, EntityManagerInterface $em)
    {
        parent::__construct($request, $security, $em);
        $this->em = $em;

        $user = $security->getUser();
        $currentRequest = $request->getCurrentRequest();

        $workspaceId = $currentRequest->attributes->get('workspaceId');

        if ($workspaceId) {
            $this->checkWorkspace($workspaceId);
        }

        $workspaceMemberId = $currentRequest->attributes->get('workspaceMemberId');
        if ($workspaceMemberId) {
            $workspaceMember = $em->getRepository(WorkspaceMember::class)->find($workspaceMemberId);
            if (!$workspaceMember) {
                throw new Exception("Workspace member not found");
            }

            if ($workspaceMember->getWorkspace()->getId() != $this->workspace->getId()) {
                throw new Exception("Access denied", Response::HTTP_FORBIDDEN);
            }
        }

//        $team = $this->getTeam();
//        if ($team->getId() != $this->getWorkspace()->getTeam()->getId()){
//            throw new Exception("Access denied", Response::HTTP_FORBIDDEN);
//        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getWorkspaceRepository() : WorkspaceRepository
    {
        return $this->getEntityManager()->getRepository(Workspace::class);
    }

    public function getWorkspace(): ?Workspace
    {
        return $this->workspace;
    }
}
