<?php

namespace App\Controller\Api;

use App\Attributes\Swagger\Response\Organization\OrganizationResponse;
use App\Controller\Api\Team\AbstractTeamController;
use App\Entity\Team\Team;
use App\Form\Team\TeamForm;
use Exception;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[
    OA\Tag("Teams"),
    Security(name: "BearerAuth"),
    Route('/teams'),
]
class TeamController extends AbstractTeamController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[
        Route('', name: 'teams_list', methods: ['GET']),
        OA\Get
    ]
    public function index(): JsonResponse
    {
        $teams = $this->getTeamRepository()->findAll();
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($teams), "Success");
    }


    /**
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    #[
        Route('', name: 'teams_add', methods: ['POST']),
        OA\Post
    ]
    public function create(): JsonResponse
    {
        $data = $this->getPayload();
        $data["user"] = $this->getUser()->getId();
        $form = $this->createForm(TeamForm::class);
        $form->submit($data);

        if (!$form->isValid()){
            throw new Exception("Form is not Valid");
        }

        $this->getEntityManager()->flush();
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($form->getData()), "Team created");
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[
        Route('/{teamId}', name: 'teams_read', methods: ['GET']),
        OA\Get
    ]
    public function read(?Team $teamId): JsonResponse
    {
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($teamId), "Success");
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    #[
        Route('/{teamId}', name: 'teams_update', methods: ['PUT']),
        OA\Put
    ]
    public function update(?Team $teamId): JsonResponse
    {
        $data = $this->getPayload();
        $data["user"] = $this->getUser()->getId();
        $form = $this->createForm(TeamForm::class, $teamId, ["method" => "PUT"]);
        $form->submit($data);

        if (!$form->isValid()){
            throw new Exception("Form is not Valid");
        }

        $this->getEntityManager()->flush();
        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($form->getData()), "Team updated");
    }


    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    #[
        Route('/{teamId}', name: 'teams_delete', methods: ['DELETE']),
        OA\Delete
    ]
    public function delete(?Team $teamId): JsonResponse
    {
        $this->getEntityManager()->remove($teamId);
        $this->getEntityManager()->flush();

        return $this->apiResponse($this->getCustomSymfonySerializer()->serialize($teamId), "Team deleted");
    }
}
