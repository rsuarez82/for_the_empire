<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OverviewController extends AbstractController
{
    #[Route('/overview', name: 'overview')]
    public function index(): Response
    {
        return $this->render('overview/index.html.twig', [
            'controller_name' => 'OverviewController',
        ]);
    }
}
