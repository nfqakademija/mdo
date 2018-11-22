<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddTimeController extends AbstractController
{
    public function index()
    {
        return $this->render('views/add-time.html.twig', [
            'page_name' => 'Add-Time',
        ]);
    }
}
