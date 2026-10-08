<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $name = null;

    #[ORM\OneToMany(
        mappedBy: 'department',
        targetEntity: Employee::class
    )]
    private Collection $employee;

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

    public function getEmployees(): Collection
    {
        return $this->employee;
    }
    public function __toString(): string
    {
        if (trim($this->name) !== '') {
            return $this->name;
        }
        return 'Departamento';
    }

    public function getEmployeesList(): string
    {
        $employees = [];

        foreach ($this->employee as $empl) {
            $employees[] = $empl->getId() . ' - ' . $empl->getName();
        }

        return $employees
            ? implode("\n", $employees)
            : 'Sin empleados registrados';
    }
}
