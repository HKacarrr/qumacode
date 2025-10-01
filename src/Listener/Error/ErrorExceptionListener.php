<?php

namespace App\Listener\Error;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ErrorExceptionListener implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $response = $event->getThrowable();
        $responseMessage = $response->getMessage();
        $responseCode = $response->getCode() == 0 ? Response::HTTP_FORBIDDEN : $response->getCode();

        $jsonResponse = new JsonResponse(["message" => $responseMessage], $responseCode);
        $event->setResponse($jsonResponse);
    }


    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
