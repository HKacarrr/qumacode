<?php

namespace App\Controller\Api\Auth;

use App\Controller\AbstractApiController;
use App\Exception\Auth\Login\LoginFailedException;
use App\Form\Auth\LoginForm;
use App\Service\Auth\JsonLoginService;
use Exception;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use OpenApi\Attributes as OA;

class LoginController extends AbstractApiController
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
            // TODO Burası postmanden kendimiz için kullandığımız alan
            $payload = $request->toArray();
            $tokens = $jsonLoginService->login($payload["email"], $payload["password"]);
//            $loginCheckUrl = $this->generateUrl("api_login_check",[],UrlGeneratorInterface::ABSOLUTE_URL);
////            $loginCheckUrl = "http://php/api/login_check"; /** For docker route */
//            $response = $httpClient->request("POST",$loginCheckUrl,[
//                "json" => $payload
//            ]);
//            $tokens = $response->toArray();

            return new JsonResponse(["token" => $tokens]);

        }catch (Exception|LoginFailedException|ServerExceptionInterface|RedirectionExceptionInterface|ClientExceptionInterface $e){

            return new JsonResponse(["error" => $e->getMessage()], Response::HTTP_FORBIDDEN);
        }
    }
}
