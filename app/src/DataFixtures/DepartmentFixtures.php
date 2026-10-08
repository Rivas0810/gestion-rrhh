<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $departments = [
            'Recursos Humanos',
            'Tecnologías de la Información',
            'Contabilidad',
            'Ventas',
            'Marketing',
        ];

        foreach ($departments as $index => $name) {
            $department = new Department();
            $department->setName($name);

            $manager->persist($department);

            // Reference para poder utilizar este Department
            // desde otros fixtures.
            $this->addReference(
                'department-' . $index,
                $department
            );
        }
        $manager->flush();
    }
}