<?php

namespace App\Controller\Api\Team\Workspace\WorkspaceMember;

use App\Controller\Api\Team\Workspace\AbstractWorkspaceController;
use App\Entity\Workspace\WorkspaceMember;
use App\Form\Workspace\WorkspaceMemberForm;
use Exception;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[OA\Tag("Workspace Member"), Security(name: "BearerAuth"), Route('/members')]
class WorkspaceMemberController extends AbstractWorkspaceController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('', name: 'workspace_member_list', methods: ['GET']), OA\Get]
    public function index(): JsonResponse
    {
        $workspace = $this->getWorkspace();
        $workspaceMembers = $workspace->getWorkspaceMembers();

        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($workspaceMembers));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    #[Route('', name: 'workspace_member_create', methods: ['POST']), OA\Post]
    public function create(): JsonResponse
    {
        $data = $this->getPayload();
        $data['workspace'] = $this->getWorkspace()->getId();
        $form = $this->createForm(WorkspaceMemberForm::class);

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
    #[Route('/{workspaceMemberId}', name: 'workspace_member_read', methods: ['GET']), OA\Get]
    public function read(?WorkspaceMember $workspaceMemberId): JsonResponse
    {
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($workspaceMemberId), "Success");
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/{workspaceMemberId}', name: 'workspace_member_update', methods: ['PUT']), OA\Put]
    public function update(?WorkspaceMember $workspaceMemberId): JsonResponse
    {
        $data = $this->getPayload();
        $data['workspace'] = $this->getWorkspace()->getId();
        $form = $this->createForm(WorkspaceMemberForm::class, $workspaceMemberId, ['method' => 'PUT']);

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
    #[Route('/{workspaceMemberId}', name: '_delete', methods: ['DELETE']), OA\Delete]
    public function delete(?WorkspaceMember $workspaceMemberId): JsonResponse
    {
        $em = $this->getEntityManager();
        $em->remove($workspaceMemberId);

        $this->makeFlush();
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($workspaceMemberId), "Success");
    }
}
