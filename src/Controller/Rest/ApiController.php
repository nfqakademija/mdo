<?php

namespace App\Controller\Rest;


use App\Entity\Customer;
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

        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);

        $freeSlotOfDayColl = $sessionRepo->findFreeTimeSlotByDate($date);

        $freeSlotOfDayArray = [];

        //transform collection data to proper format array
        foreach ($freeSlotOfDayColl as $value){
            $freeSlotOfDayArray[str_replace(':', "",$value->getStartsAt()->format('H:i').'-'.$value->getEndsAt()->format('H:i'))] = 1;
        }

        return View::create($freeSlotOfDayArray, Response::HTTP_OK);

        //Reikia gauti laisvas vietas pagal data ir transforminti i apacioje esanti masyva
//        $dateArr = [
//            '0100-0140' =>  1,
//            '0500-0600' =>  1,
//            '0600-0650' =>  1,
//        ];

    }

    /**
     * Create an booking
     * @Rest\Post("/calendar")
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function postBookingData(Request $request){

        //Find slot for booking
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);

        $times = explode("-", $request->get('timeslot'));

        $startTime = $this->stringInsert($times[0], ':', 2).':00';
        $endTime   = $this->stringInsert($times[1], ':', 2).':00';

        $customer = New Customer();
        $customer->setFullName($request->get('guest_name').', '.$request->get('guest_surname'));
        $customer->setPhone($request->get('guest_phone'));
        $customer->setEmail($request->get('guest_email'));
        $customer->setComment($request->get('guest_comment'));
        $customer->setRegisteredAt(new \DateTime('NOW'));

        //Get free slot id
        $freeSlotId = $sessionRepo->checkSlotFree($request->get('date'), $startTime, $endTime);

        //Find record by id for updating
        $session = $sessionRepo->find($freeSlotId[0]['id']);


        if (!$session) {
            throw $this->createNotFoundException(
                 'Pavelavai, laikas rezervuotas'
            );
        }

        $session->setStatus('reserved');
        $session->setCustomer($customer);

        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->persist($session);
        $em->flush();


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

    private function stringInsert(string $str, string $insertstr, int $pos) :string
    {
        $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
        return $str;
    }

    //Dar reikia prideti kazkokia Api autentifikacija, oAuth, JWT, o gal cia Symfony jau kazkas yra tam reikalui
    //PS. Bandziau kreiptis i api per Postman tai kaip ir veikia

}