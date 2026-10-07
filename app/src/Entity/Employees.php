<?php

namespace App\Entity;

use App\Repository\EmployeesRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: EmployeesRepository::class)]
class Employees
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $name = null;

    #[ORM\Column(length: 70)]
    private ?string $email = null;

    #[ORM\Column(length: 10)]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Departments $departments = null;

    #[ORM\OneToMany(
        mappedBy: 'employees',
        targetEntity: AttendanceRecords::class
    )]
    private Collection $AttendanceRecords;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDepartments(): ?Departments
    {
        return $this->departments;
    }

    public function setDepartments(Departments $departments): static
    {
        $this->departments = $departments;

        return $this;
    }

    public function getAttendanceRecords(): Collection
    {
        return $this->AttendanceRecords;
    }
    public function setAttendanceRecords(Collection $attendanceRecords): static 
    {
        $this->AttendanceRecords = $attendanceRecords;
        return $this;
    }

}
