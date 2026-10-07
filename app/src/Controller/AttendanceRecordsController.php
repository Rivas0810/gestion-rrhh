<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AttendanceRecordsController extends AbstractController
{
    #[Route('/attendance/records', name: 'app_attendance_records')]
    public function index(): Response
    {
        return $this->render('attendance_records/index.html.twig', [
            'controller_name' => 'AttendanceRecordsController',
        ]);
    }
}
