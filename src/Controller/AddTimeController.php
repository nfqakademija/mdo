<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Entity\WeekDays;
use App\Repositories\SessionRepository;
use App\Repository\AvailabilityRepository;
use App\Repository\WeekDaysRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AddTimeController extends AbstractController
{
    public function index()
    {
        $sessions = new SessionRepository();
        $availabilityRepo = $this->getDoctrine()->getRepository(Availability::class);

        //$weekDayRepo = $this->getDoctrine()->getRepository(WeekDays::class);
//        $data = $weekDayRepo->getId()->getStartTime();
//
//        echo '<pre>';
//        print_r($data);

        return $this->render('views/add-time.html.twig', [
            'page_name' => 'Add-Time',
            'sessions'=> $sessions->getData(),
            'availability_data' => $availabilityRepo->findAll(),
        ]);
    }


    /**
     * @Route("/time-slot-submit", name="submit-add-slot", methods={"POST"})
     * @param Request $request
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request){

        $em = $this->getDoctrine()->getManager();
        $weekDayRepo = $this->getDoctrine()->getRepository(WeekDays::class);

        //find and set day ID
        $weekDay = $weekDayRepo->findDayId($request->get('Day'));


        $availability = new Availability();
        $availability->setDayOfWeek($weekDay->getId());
        $availability->setStartTime(new \DateTime($request->get('From').':00' ));
        $availability->setEndTime(new \DateTime($request->get('To').':00' ));
        $availability->setSlotSpace(1);
        $em->persist($availability);
        $em->flush();

        return $this->json(array('status' => '200'));

    }
}
