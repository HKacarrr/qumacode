<?php

namespace App\Core\Traits;

use Symfony\Component\Form\FormFactoryInterface;

trait FormFactoryInterfaceProviderTrait
{
    protected function getFormFactory(): FormFactoryInterface
    {
        return $this->container->get(FormFactoryInterface::class);
    }
}
