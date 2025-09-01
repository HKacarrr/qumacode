<?php

namespace App\Core\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;

trait PrimaryKeyTrait
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

//    #[ORM\PrePersist]
//    public function prePersist(): void
//    {
//        if (empty($this->id)) {
//            $this->id = Uuid::v7();
//        }
//    }
}
