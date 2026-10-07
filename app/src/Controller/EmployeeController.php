<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\BrowserKit\Response; IMPORTANTE: en el futuro debería prestarle atención / Para pruebas integración con PHP
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Attribute\Route;

final class EmployeeController extends AbstractController
{
    
    public function index(): Response
    {
        return $this->render('employee/index.html.twig');
    }
}
