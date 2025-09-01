<?php

namespace App\Core\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;

trait DeleteAtTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $deletedAt;


    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt = null): static
    {
        if (!$deletedAt){
            $deletedAt = new \DateTime();
        }

        $this->deletedAt = $deletedAt;
        return $this;
    }
}
