<?php

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\Employee;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $employees = [
            [
                'name' => 'Juan Pérez',
                'employee_identifier'=> '000JP',
                'email' => 'juan.perez@milenio.com',
                'phone' => '3312345678',
                'department' => 0,
            ],

            [
                'name' => 'Ana López',
                'employee_identifier'=> '000AL',
                'email' => 'ana.lopez@milenio.com',
                'phone' => '3345678901',
                'department' => 1,
            ],
            [
                'name' => 'Sofía Martínez',
                'employee_identifier'=> '000SM',
                'email' => 'sofia.martinez@milenio.com',
                'phone' => '3367890123',
                'department' => 2,
            ],
            [
                'name' => 'Miguel Torres',
                'employee_identifier'=> '000MT',
                'email' => 'miguel.torres@milenio.com',
                'phone' => '3378901234',
                'department' => 3,
            ],

            [
                'name' => 'Diego Ramírez',
                'employee_identifier'=> '000DR',
                'email' => 'diego.ramirez@milenio.com',
                'phone' => '3390123456',
                'department' => 4,
            ],
        ];

        foreach ($employees as $index => $data) {
            $employee = new Employee();

            $employee->setName($data['name']);
            $employee->setEmployeeIdentifier($data['employee_identifier']);
            $employee->setEmail($data['email']);
            $employee->setPhone($data['phone']);

            $department = $this->getReference(
                'department-' . $data['department'],
                Department::class
            );

            $employee->setDepartment($department);
            $manager->persist($employee);

            $this->addReference(
                'employee-' . $index,
                $employee
            );
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DepartmentFixtures::class,
        ];
    }
}