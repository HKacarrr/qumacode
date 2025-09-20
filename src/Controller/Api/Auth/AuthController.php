<?php

namespace App\Controller\Api\Auth;

use App\Controller\AbstractApiController;
use App\Entity\User\User;
use App\Exception\Auth\Login\LoginFailedException;
use App\Form\Auth\LoginForm;
use App\Form\Auth\RegisterForm;
use App\Service\Auth\JsonLoginService;
use Exception;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use OpenApi\Attributes as OA;


#[Route('/auth')]
class AuthController extends AbstractApiController
{
    /**
     * Login Process
     */
    #[Route('/login', name: 'login', methods: ['POST'])]
    #[OA\RequestBody(
        description: "Member login payload",
        required: true,
        content: new Model(type: LoginForm::class)
    )]
    #[OA\Response(
        response: 200,
        description: "Token Object"
    )]
    #[OA\Response(
        response: 400,
        description: "String"
    )]
    public function login(Request $request, JsonLoginService $jsonLoginService): JsonResponse
    {
        try {
            $payload = $request->toArray();
            $tokens = $jsonLoginService->login($payload["email"], $payload["password"]);

            return new JsonResponse(["token" => $tokens]);
        }catch (Exception|LoginFailedException|ServerExceptionInterface|RedirectionExceptionInterface|ClientExceptionInterface $e){

            return new JsonResponse(["error" => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }
    }


    #[Route('/register', name: 'register', methods: ['POST'])]
    #[OA\RequestBody(
        description: "Member register payload",
        required: true,
        content: new Model(type: RegisterForm::class)
    )]
    public function register(Request $request, FormFactoryInterface $formFactory)
    {
        try {
            $payload = $request->toArray();
            $form = $formFactory->create(RegisterForm::class);

            $form->submit($payload);
            $this->getEntityManager()->flush();
            return new JsonResponse(["message" => "Success"], Response::HTTP_OK);
        }catch (Exception $e){
            return new JsonResponse(["message" => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }
    }
}
