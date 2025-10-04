<?php

namespace App\Controller\Api\Team;

use App\Attributes\Swagger\Response\Organization\OrganizationResponse;
use App\Entity\Team\TeamMemberRole;
use Nelmio\ApiDocBundle\Attribute\Security;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag("Team"), Security(name: "BearerAuth"), Route('/team-member-roles')]
class TeamMemberRoleController extends AbstractTeamController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('', name: 'team_member_role_list', methods: ['GET']), OA\Get]
    public function index(): JsonResponse
    {
        $teamMemberRoles = $this->getEntityManager()->getRepository(TeamMemberRole::class)->findAll();
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($teamMemberRoles), "Success");
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/{teamMemberRoleId}', name: 'team_member_role_read', methods: ['GET']), OA\Get]
    public function read(?TeamMemberRole $teamMemberRoleId): JsonResponse
    {
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($teamMemberRoleId), "Success");
    }
}
