<?php

namespace App\Entity;

use App\Repository\DepartmentsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: DepartmentsRepository::class)]
class Departments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $name = null;

    #[ORM\OneToMany(
        mappedBy: 'departments',
        targetEntity: Employees::class
    )]
    private Collection $employees;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setEmployees(Collection $employees): static
    {
        $this->employees = $employees;

        return $this;
    }

    public function getEmployees(): Collection
    {
        return $this->employees;
    }
}
