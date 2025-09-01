<?php

namespace App\Core\Traits\System;

use Symfony\Component\Form\FormFactoryInterface;

trait FormFactoryInterfaceProviderTrait
{
    protected function getFormFactory(): FormFactoryInterface
    {
        return $this->container->get(FormFactoryInterface::class);
    }
}
