<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class SettingsController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('settings/index.html.twig');
    }
}
