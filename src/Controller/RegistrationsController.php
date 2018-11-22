<?php

namespace App\Controller;

use App\Repositories\RegistrationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationsController extends Controller
{
    public function index()
    {
        $regRepo = new RegistrationsRepository();
        return $this->render('views/registrations.html.twig', [
            'page_name' => 'Registrations',
            'registrations' => $regRepo->getRegistrations()
        ]);
    }
}
