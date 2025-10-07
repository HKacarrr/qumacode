<?php

namespace App\Controller\Api\Team\Workspace\traits;

use App\Entity\Workspace\Workspace;
use Exception;

trait AbstractWorkspaceControllerPrivateFunctionProviderTrait
{
    /**
     * @throws Exception
     */
    private function checkWorkspace($workspaceId): void
    {
        $workspace = $this->em->getRepository(Workspace::class)->find($workspaceId);
        if (!$workspace) {
            throw new Exception("Workspace not found");
        }

        $this->workspace = $workspace;
    }
}
