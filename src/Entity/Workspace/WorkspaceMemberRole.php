<?php

namespace App\Entity\Workspace;

use App\Core\Traits\Entity\PrimaryKeyTrait;
use App\Repository\Workspace\WorkspaceMemberRoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkspaceMemberRoleRepository::class)]
class WorkspaceMemberRole
{
    use PrimaryKeyTrait;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $alias = null;

    #[ORM\Column]
    private ?int $degree = null;


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    public function getDegree(): ?int
    {
        return $this->degree;
    }

    public function setDegree(int $degree): static
    {
        $this->degree = $degree;

        return $this;
    }
}
