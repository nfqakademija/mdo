<?php

namespace App\Controller\Rest;


use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends FOSRestController
{

    /**
    * Initialize calendar
    * @Rest\Get("/calendar")
    */
    public function getCalendar()
    {

        //Reikia paimti laisvus laikus is DB ir transforminti i apacioje esanti masyva
        $dummyData = [
            'Mon' => [
                '0100-0140' =>  4,
                '0500-0540' =>  2
            ],
            'Fri' => [
                '0300-0400' =>  10,
                '0500-0700' =>  16
            ],
        ];

        return View::create($dummyData, Response::HTTP_OK);
    }

    /**
     * Get free time slot array
     * @Rest\Get("/date/{date}")
     */
    public function getFreeTimesByDate(string $date)
    {

        //Reikia gauti laisvas vietas pagal data ir transforminti i apacioje esanti masyva
        $dateArr = [
            '0100-0140' =>  4,
            '0500-0600' =>  2,
            '0600-0650' =>  1,
        ];

        return View::create($date, Response::HTTP_OK);

    }

    /**
     * Create an booking
     * @Rest\Post("/calendar")
     * @param Request $request
     */
    public function postBookingData(Request $request){

        //Duomenys kurie ateina is WP kai submitini registarijos forma. Atrodo taip:
        [
            'date' => '2018-12-17',
            'timestamp' => '1544763600',
            'timeslot' => '0500-0600',
            'calendar_id' => 0, // jeigu bus du kalendoriai vaiku ir suaugusiuju
            'guest_name' => 'vardas',
            'guest_surname' => 'pavarde',
            'guest_phone' => '865289804', //skambinam situ numeriu jeigu kazkas neaisku :D
            'guest_email' => 'mail@mail.com',
            'guest_comment' => 'komentaras'
        ];

    }


    //Dar reikia prideti kazkokia Api autentifikacija, oAuth, JWT, o gal cia Symfony jau kazkas yra tam reikalui
    //PS. Bandziau kreiptis i api per Postman tai kaip ir veikia

}