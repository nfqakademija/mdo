<?php

namespace App\Controller;

use App\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationsController extends Controller
{
    public function index()
    {
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);

        return $this->render('views/registrations.html.twig', [
            'page_name' => 'Registrations',
            'registrations' => $sessionRepo->findRegistrationList()
        ]);
    }
}
