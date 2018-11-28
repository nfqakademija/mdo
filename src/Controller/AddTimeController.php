<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AddTimeController extends AbstractController
{
    public function index()
    {
        return $this->render('views/add-time.html.twig', [
            'page_name' => 'Add-Time',
        ]);
    }


    /**
     * @Route("/time-slot-submit", name="submit-add-slot", methods={"POST"})
     * @param Request $request
     */
    public function create(Request $request){

        print_r($request->getContent());
        die();

    }
}
