<?php

namespace App\Entity;

use App\Repository\AttendanceRecordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AttendanceRecordRepository::class)]
class AttendanceRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $entry_time = null;

    #[Assert\GreaterThanOrEqual(propertyPath: 'entry_time' , message: 'La fecha de salida debe ser posterior a la fecha de entrada.')]
    #[ORM\Column(nullable: true)]
    private ?\DateTime $exit_time = null;

    #[ORM\ManyToOne(inversedBy: 'AttendanceRecord')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee = null;
    public function __construct()
    {
        $this->entry_time = new \DateTime('today');
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntryTime(): ?\DateTime
    {
        return $this->entry_time;
    }

    public function setEntryTime(?\DateTime $entry_time): static
    {
        $this->entry_time = $entry_time;

        return $this;
    }

    public function getExitTime(): ?\DateTime
    {
        return $this->exit_time;
    }

    public function setExitTime(?\DateTime $exit_time): static
    {
        $this->exit_time = $exit_time;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;

        return $this;
    }

    public function __toString(): string
    {
        if (trim($this->employee) !== '') {
            return $this->employee->__toString();
        }
        return 'Registro de Asistencia';
    }

    
}
