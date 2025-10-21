<?php

namespace App\Controller\Api\Team\TeamMember;

use App\Entity\Team\TeamMember;
use App\Form\Team\TeamMemberForm;
use Exception;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag("Team Members"), Security(name: "BearerAuth"), Route('/team-members')]
class TeamMemberController extends AbstractTeamMemberController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('', name: 'team_members_list', methods: ['GET']), OA\Get]
    public function index(): JsonResponse
    {
        $team = $this->getTeam();
        $teamMembers = $team->getTeamMembers();

        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($teamMembers), "Success");
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    #[Route('', name: 'team_member_create', methods: ['POST']), OA\Post]
    public function create(): JsonResponse
    {
        $data = $this->getPayload();
        $data['team'] = $this->getTeam()->getId();
        $form = $this->createForm(TeamMemberForm::class);

        $form->submit($data);
        if (!$form->isValid())
            throw new Exception("Form is not valid", Response::HTTP_FORBIDDEN);

        $this->makeFlush();
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($form->getData()), "Success");
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/{teamMemberId}', name: 'team_member_read', methods: ['GET']), OA\Get]
    public function read(?TeamMember $teamMemberId): JsonResponse
    {
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($teamMemberId), "Success");
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    #[Route('/{teamMemberId}', name: 'team_member_update', methods: ['PUT']), OA\Put]
    public function update(?TeamMember $teamMemberId): JsonResponse
    {
        $data = $this->getPayload();
        $data["team"] = $this->getTeam()->getId();

        $form = $this->createForm(TeamMemberForm::class, $teamMemberId, ['method' => 'PUT']);
        $form->submit($data);

        if (!$form->isValid())
            throw new Exception("Form is not valid", Response::HTTP_FORBIDDEN);

        $this->makeFlush();
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($form->getData()), "Success");
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    #[Route('/{teamMemberId}', name: 'team_member_delete', methods: ['DELETE']), OA\Delete]
    public function delete(?TeamMember $teamMemberId)
    {
        $this->getEntityManager()->remove($teamMemberId);
        $this->makeFlush();

        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($teamMemberId), "Success");
    }
}
