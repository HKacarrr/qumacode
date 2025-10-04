<?php

namespace App\Controller\Api\Team\Traits;

use App\Entity\Team\Team;
use App\Entity\Team\TeamMember;
use App\Entity\User\User;
use Exception;

trait AbstractTeamControllerPrivateFunctionProviderTrait
{
    /**
     * @throws Exception
     */
    private function checkTeam($teamId): Team
    {
        /** @var Team $team */
        $team = $this->em->getRepository(Team::class)->find($teamId);
        if (!$team){
            throw new Exception("Team not found");
        }
        $this->team = $team;
        return $team;
    }


    /**
     * @throws Exception
     */
    private function memberCheck(User $user): Team
    {
        /** @var TeamMember $organizationMemberByOrganizationAndUser */
        $teamMemberByTeamAndUser = $this->em->getRepository(TeamMember::class)->getMemberByOrganizationAndUser($this->team, $user);
        if (!$teamMemberByTeamAndUser){
            throw new Exception("User is not exist in the organization");
        }

        return $teamMemberByTeamAndUser;
    }


//    private function checkMemberRole(TeamMember $teamMember): void
//    {
//        $memberTeamRole = $teamMember->getOrganizationMemberRole()->getAlias();
//        $isRoleExistOnTheRequest = in_array($memberTeamRole, ApiRoleHierarchies::HIERARCHIES[$this->requestMethod]["organizationRole"]);
//        if  (!$isRoleExistOnTheRequest){
//            throw new Exception("Access denied", Response::HTTP_FORBIDDEN);
//        }
//    }
}
