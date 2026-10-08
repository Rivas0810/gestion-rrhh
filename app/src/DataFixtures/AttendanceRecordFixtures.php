<?php

namespace App\DataFixtures;

use App\Entity\AttendanceRecord;
use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AttendanceRecordFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $records = [
            [
                'employee' => 0,
                'entry_time' => new \DateTime('2026-10-06 08:00:00'),
                'exit_time' => new \DateTime('2026-10-06 17:00:00'),
            ],
            [
                'employee' => 0,
                'entry_time' => new \DateTime('2026-10-07 08:15:00'),
                'exit_time' => new \DateTime('2026-10-07 17:10:00'),
            ],
            [
                'employee' => 1,
                'entry_time' => new \DateTime('2026-10-06 08:30:00'),
                'exit_time' => new \DateTime('2026-10-06 16:30:00'),
            ],
            [
                'employee' => 1,
                'entry_time' => new \DateTime('2026-10-07 08:20:00'),
                'exit_time' => null,
            ],
            [
                'employee' => 2,
                'entry_time' => new \DateTime('2026-10-06 09:00:00'),
                'exit_time' => new \DateTime('2026-10-06 18:00:00'),
            ],
            [
                'employee' => 3,
                'entry_time' => new \DateTime('2026-10-07 08:45:00'),
                'exit_time' => null,
            ],
            [
                'employee' => 4,
                'entry_time' => new \DateTime('2026-10-07 09:00:00'),
                'exit_time' => new \DateTime('2026-10-07 18:00:00'),
            ],
        ];

        foreach ($records as $data) {
            $attendanceRecord = new AttendanceRecord();

            $employee = $this->getReference(
                'employee-' . $data['employee'],
                Employee::class
            );

            $attendanceRecord->setEmployee($employee);
            $attendanceRecord->setEntryTime($data['entry_time']);
            $attendanceRecord->setExitTime($data['exit_time']);

            $manager->persist($attendanceRecord);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EmployeeFixtures::class,
        ];
    }
}