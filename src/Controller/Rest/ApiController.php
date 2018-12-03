<?php

namespace App\Controller\Rest;


use App\Entity\Session;
use App\Repository\SessionRepository;
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
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);

        $calendarInitColl = $sessionRepo->init_calendar();

        $calendarInitArray = [];

        //transform collection data to proper format array
        foreach ($calendarInitColl as $value){
            $calendarInitArray[str_replace('-', "", $value->getReservedAt()->format('Y-m-d'))] = [
                'free' => 1
            ];
        }

        return View::create($calendarInitArray, Response::HTTP_OK);
    }

    /**
     * Get free time slot array
     * @Rest\Get("/date/{date}")
     */
    public function getFreeTimesByDate(string $date)
    {

        //Reikia gauti laisvas vietas pagal data ir transforminti i apacioje esanti masyva
//        $dateArr = [
//            '0100-0140' =>  1,
//            '0500-0600' =>  1,
//            '0600-0650' =>  1,
//        ];

        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);

        $freeSlotOfDayColl = $sessionRepo->findFreeTimeSlotByDate($date);

        $freeSlotOfDayArray = [];

        //transform collection data to proper format array
        foreach ($freeSlotOfDayColl as $value){
            $freeSlotOfDayArray[str_replace(':', "",$value->getStartsAt()->format('H:i').'-'.$value->getEndsAt()->format('H:i'))] = 1;
        }

        return View::create($freeSlotOfDayArray, Response::HTTP_OK);

    }

    /**
     * Create an booking
     * @Rest\Post("/calendar")
     * @param Request $request
     * @return View
     */
    public function postBookingData(Request $request){

        //Find slot for booking
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);

        $times = explode("-", $request->get('timeslot'));

        $startTime = strpos($times[0], ':', 2).':00';
        $endTime =   strpos($times[1], ':', 2).':00';

        $slot = $sessionRepo->checkSlotFree($request->get('date'), $startTime, $endTime);

        $message = ['Jusu rezervacija sekminga'];


        return View::create($message, Response::HTTP_OK);

        //Duomenys kurie ateina is WP kai submitini registarijos forma. Atrodo taip:
//        [
//            'date' => '2018-12-17',
//            'timestamp' => '1544763600',
//            'timeslot' => '0500-0600',
//            'calendar_id' => 0, // jeigu bus du kalendoriai vaiku ir suaugusiuju
//            'guest_name' => 'vardas',
//            'guest_surname' => 'pavarde',
//            'guest_phone' => '865289804', //skambinam situ numeriu jeigu kazkas neaisku :D
//            'guest_email' => 'mail@mail.com',
//            'guest_comment' => 'komentaras'
//        ];

    }


    private function putSymbolInPlace(string $string = NULL, string $put = NULL, $position=false) :string
    {
        $d1=$d2=$i=false;
        $d=array(strlen($string), strlen($put));
        if($position > $d[0]) $position=$d[0];
        for($i=$d[0]; $i >= $position; $i--) $string[$i+$d[1]]=$string[$i];
        for($i=0; $i<$d[1]; $i++) $string[$position+$i]=$put[$i];
        return $string;
    }

    //Dar reikia prideti kazkokia Api autentifikacija, oAuth, JWT, o gal cia Symfony jau kazkas yra tam reikalui
    //PS. Bandziau kreiptis i api per Postman tai kaip ir veikia

}