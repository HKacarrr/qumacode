<?php

namespace App\Controller\Api\Team;

use App\Controller\AbstractApiController;
use App\Controller\Api\Team\Traits\AbstractTeamControllerPrivateFunctionProviderTrait;
use App\Entity\Team\Team;
use App\Entity\Team\TeamMember;
use App\Entity\User\User;
use App\Repository\Team\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractTeamController extends AbstractApiController
{
    use AbstractTeamControllerPrivateFunctionProviderTrait;

    private ?Team $team = null;
    private ?string $requestMethod = null;
    private ?EntityManagerInterface $em = null;

    /**
     * @throws Exception
     */
    public function __construct(RequestStack $request, Security $security, EntityManagerInterface $em)
    {
        /** @var User $user */
        $user = $security->getUser();
        $currentRequest = $request->getCurrentRequest();
        $teamId = $currentRequest->attributes->get('teamId');

        $this->requestMethod = $currentRequest->getMethod();
        $this->em = $em;

        if ($teamId){
            $this->checkTeam($teamId);
            $this->memberCheck($user);
//            $this->checkMemberRole($teamMemberByTeamAndUser);
        }

        $teamMemberId = $currentRequest->attributes->get('teamMemberId');
        if ($teamMemberId) {
            $teamMember = $em->getRepository(TeamMember::class)->find($teamMemberId);
            if (!$teamMember) {
                throw new Exception("Team member not found");
            }

            if ($teamMember->getTeam()->getId() != $this->team->getId()) {
                throw new Exception("Access denied", Response::HTTP_FORBIDDEN);
            }
        }
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getTeamRepository(): TeamRepository
    {
        return $this->getEntityManager()->getRepository(Team::class);
    }


    public function getTeam(): ?Team
    {
        return $this->team;
    }
}
