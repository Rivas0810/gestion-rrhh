<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
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

    #[ORM\ManyToOne(inversedBy: 'employee')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Department $department = null;

    #[ORM\OneToMany(
        mappedBy: 'employee',
        targetEntity: AttendanceRecord::class
        )]
    private Collection $AttendanceRecord;

    #[ORM\Column(length:10, nullable: true)]
    private ?string $employee_identifier = null;

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

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(Department $department): static
    {
        $this->department = $department;

        return $this;
    }

    public function getEmployeeIdentifier(): ?string
    {
        return $this->employee_identifier;
    }

    public function setEmployeeIdentifier(string $employee_identifier): static
    {
        $this->employee_identifier = $employee_identifier;

        return $this;
    }
    public function getAttendanceRecords(): Collection
    {
        return $this->AttendanceRecord;
    }
    public function __toString(): string
    {
        if (trim($this->name) !== '') {
        return $this->name;
        }
        return 'Empleado';
    }

    public function getAttendanceRecordList(): string
    {
        $attendance_records = [];

        foreach ($this->AttendanceRecord as $attendance) {
            $entry_time = $attendance->getEntryTime();
            $exit_time = $attendance->getExitTime();

            $entry_time = $entry_time !== null
                ? $entry_time->format('d M Y H:i:s')
                : 'Hora entrada no asignada';

            $exit_time = $exit_time !== null
                ? $exit_time->format('d M Y H:i:s')
                : 'Hora salida no asignada';

            $attendance_records[] = $entry_time . ' - ' . $exit_time;
        }

        return $attendance_records
            ? implode("\n", $attendance_records)
            : 'Sin entradas ni salidas registradas';
    }
}
