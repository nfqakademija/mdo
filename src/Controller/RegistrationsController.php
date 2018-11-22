<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationsController extends Controller
{
    public function index()
    {
        return $this->render('views/registrations.html.twig', [
            'page_name' => 'Registrations',
        ]);
    }
}
