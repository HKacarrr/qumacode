<?php

namespace App\Controller\Api\Team;

use App\Attributes\Swagger\Response\Organization\OrganizationResponse;
use App\Entity\Team\Team;
use Nelmio\ApiDocBundle\Attribute\Security;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

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


    #[
        Route('', name: 'teams_add', methods: ['POST']),
        OA\Post
    ]
    public function create()
    {

    }


    #[
        Route('/{teamId}', name: 'teams_read', methods: ['GET']),
        OA\Get
    ]
    public function read()
    {

    }


    #[
        Route('/{teamId}', name: 'teams_update', methods: ['PUT']),
        OA\Put
    ]
    public function update()
    {

    }


    #[
        Route('/{teamId}', name: 'teams_delete', methods: ['DELETE']),
        OA\Delete
    ]
    public function delete()
    {

    }
}
