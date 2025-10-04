<?php

namespace App\Controller\Api\Team\TeamMember;

use App\Controller\Api\Team\AbstractTeamController;
use App\Entity\Team\TeamMember;
use App\Repository\Team\TeamMemberRepository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class AbstractTeamMemberController extends AbstractTeamController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function TeamMemberRepository(): TeamMemberRepository
    {
        return $this->getEntityManager()->getRepository(TeamMember::class);
    }
}
