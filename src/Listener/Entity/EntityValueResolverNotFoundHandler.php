<?php

namespace App\Listener\Entity;

use App\Core\Services\ApiResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Translation\TranslatorInterface;

class EntityValueResolverNotFoundHandler implements EventSubscriberInterface
{

    private array $reflectorParameters = [\ReflectionParameter::class];
    public function __construct(private TranslatorInterface $translator, private ApiResponse $apiResponse)
    {
    }

    public function notFoundException(ControllerEvent $event): void
    {

        $reflectorParameters = $event->getControllerReflector()->getParameters();

        /** @var \ReflectionParameter $reflectorParameter */
        foreach ($reflectorParameters as $reflectorParameter) {
            $this->reflectorParameters[$reflectorParameter->getName()] = $reflectorParameter;
        }
    }
    public function notFoundException2(ControllerArgumentsEvent $event): void
    {
//        dd($this->a);
        $arguments = $event->getNamedArguments();
        $request = $event->getRequest();


        foreach ($arguments as $key => $argument) {

//            if(!$argument or !is_object($argument)){
//                continue;
//            }

            $reflectorParameter = $this->reflectorParameters[$key];
            if(!$reflectorParameter){
                continue;
            }
            $allowNull = $reflectorParameter->allowsNull();
            $value = $request->attributes->get($reflectorParameter->getName());

            if($allowNull && $value == null){
                continue;
            }

            if(!$argument){
                $this->apiResponse->jsonResponse(null,$this->translator->trans("dynamic.error.notFound.".$key),null,404)->send();
                exit;
            }

            if (is_object($argument) and property_exists($argument, "deletedAt") and $argument->getDeletedAt()){
                $this->apiResponse->jsonResponse(null,$this->translator->trans("dynamic.error.alreadyBeenDeleted.".$key),null,404)->send();
                exit;
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => [
                ['notFoundException', 100]
            ],
            KernelEvents::CONTROLLER_ARGUMENTS => [
                ['notFoundException2', 100]
            ],
        ];
    }
}
