<?php

namespace App\Core\Traits;

use App\Serializer\Jms\CustomJmsSerializer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait CustomJmsSerializerProviderTrait
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getCustomJmsSerializer(): CustomJmsSerializer
    {
        return $this->container->get(CustomJmsSerializer::class);
    }
}
