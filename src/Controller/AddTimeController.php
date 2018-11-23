<?php

namespace App\Controller;

use App\Repositories\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddTimeController extends AbstractController
{
    public function index()
    {
        $sessions = new SessionRepository();
        return $this->render('views/add-time.html.twig', [
            'page_name' => 'Add-Time',
            'sessions'=> $sessions->getData()
        ]);
    }
}
