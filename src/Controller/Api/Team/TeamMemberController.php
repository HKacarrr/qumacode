<?php

namespace App\Controller\Api\Team;

use App\Attributes\Swagger\Response\Organization\OrganizationResponse;
use Nelmio\ApiDocBundle\Attribute\Security;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[OA\Tag("Team"), Security(name: "BearerAuth"), Route('/team')]
class TeamMemberController extends AbstractTeamController
{
    #[Route('', name: '_list', methods: ['GET']), OA\Get]
    public function index()
    {
    }

    #[Route('', name: '_create', methods: ['POST']), OA\Post]
    public function create()
    {
    }

    #[Route('/{id}', name: '_read', methods: ['GET']), OA\Get]
    public function read()
    {
    }

    #[Route('/{id}', name: '_update', methods: ['PUT']), OA\Put]
    public function update()
    {
    }

    #[Route('/{id}', name: '_delete', methods: ['DELETE']), OA\Delete]
    public function delete()
    {
    }
}
