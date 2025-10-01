<?php

namespace App\Controller\Api\Team;

use App\Controller\AbstractApiController;
use App\Entity\Team\Team;
use App\Repository\Team\TeamRepository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class AbstractTeamController extends AbstractApiController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getTeamRepository(): TeamRepository
    {
        return $this->getEntityManager()->getRepository(Team::class);
    }
}
