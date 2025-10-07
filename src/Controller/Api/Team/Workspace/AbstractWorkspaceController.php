<?php

namespace App\Controller\Api\Team\Workspace;

use App\Controller\Api\Team\AbstractTeamController;
use App\Entity\Workspace\Workspace;
use App\Repository\Workspace\WorkspaceRepository;

class AbstractWorkspaceController extends AbstractTeamController
{
    public function getWorkspaceRepository() : WorkspaceRepository
    {
        return $this->getEntityManager()->getRepository(Workspace::class);
    }
}
