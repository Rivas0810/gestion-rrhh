<?php

namespace App\Entity;

use App\Repository\AttendanceRecordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendanceRecordRepository::class)]
class AttendanceRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $entry_time = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $exit_time = null;

    #[ORM\ManyToOne(inversedBy: 'AttendanceRecord')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee = null;

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
}
