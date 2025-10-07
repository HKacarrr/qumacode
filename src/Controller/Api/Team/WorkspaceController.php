<?php

namespace App\Controller\Api\Team;

use App\Controller\Api\Team\Workspace\AbstractWorkspaceController;
use App\Entity\Workspace\Workspace;
use App\Form\Workspace\WorkspaceForm;
use Exception;
use Nelmio\ApiDocBundle\Attribute\Security;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag("Workspace"), Security(name: "BearerAuth"), Route('/workspaces')]
class WorkspaceController extends AbstractWorkspaceController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('', name: 'workspaces_list', methods: ['GET']), OA\Get]
    public function index() : JsonResponse
    {
        $workspaces = $this->getWorkspaceRepository()->findAll();
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($workspaces));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    #[Route('', name: 'workspace_create', methods: ['POST']), OA\Post]
    public function create(): JsonResponse
    {
        $data = $this->getPayload();
        $data['user'] = $this->getUser()->getId();
        $data['team'] = $this->getTeam()->getId();

        $form = $this->createForm(WorkspaceForm::class);
        $form->submit($data);

        if (!$form->isValid())
            throw new Exception("Form is not valid");

        $this->makeFlush();
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($form->getData()));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/{workspaceId}', name: 'workspace_read', methods: ['GET']), OA\Get]
    public function read(?Workspace $workspaceId): JsonResponse
    {
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($workspaceId));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    #[Route('/{workspaceId}', name: 'workspace_update', methods: ['PUT']), OA\Put]
    public function update(?Workspace $workspaceId): JsonResponse
    {
        $data = $this->getPayload();
        $data['user'] = $this->getUser()->getId();
        $data['team'] = $this->getTeam()->getId();

        $form = $this->createForm(WorkspaceForm::class, $workspaceId, ['method' => 'PUT']);
        $form->submit($data);

        if (!$form->isValid())
            throw new Exception("Form is not valid");

        $this->makeFlush();
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($form->getData()));
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    #[Route('/{workspaceId}', name: 'workspace_delete', methods: ['DELETE']), OA\Delete]
    public function delete(?Workspace $workspaceId): JsonResponse
    {
        $em = $this->getEntityManager();
        $em->remove($workspaceId);
        $this->makeFlush();

        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($workspaceId));
    }
}
