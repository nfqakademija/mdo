<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repositories\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AddTimeController extends AbstractController
{
    public function index()
    {
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);

        //print_r($sessionRepo->findByDayField('Monday'));die();

        return $this->render('views/add-time.html.twig', [
            'page_name' => 'Add-Time',
            'sessions'=> [
                'monday' => $sessionRepo->findByDayField('Monday'),
                'tuesday' => $sessionRepo->findByDayField('Tuesday'),
                'wednesday' => $sessionRepo->findByDayField('Wednesday'),
                'thursday' => $sessionRepo->findByDayField('Thursday'),
                'friday' => $sessionRepo->findByDayField('Friday'),
                'saturday' => $sessionRepo->findByDayField('Saturday'),
                'sunday' => $sessionRepo->findByDayField('Sunday')
                ]
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
//        $weekDayRepo = $this->getDoctrine()->getRepository(WeekDays::class);

        //find and set day ID
//        $weekDay = $weekDayRepo->findDayId($request->get('Day'));
//        if (!$weekDay) {
//            throw new EntityNotFoundException('This day'.$weekDay.' does not exist!');
//        }


        $session = new Session();
        $session->setDay($request->get('Day'));
        $session->setStartsAt(new \DateTime($request->get('From').':00'));
        $session->setEndsAt(new \DateTime($request->get('To').':00' ));
        $session->setReservedAt(new \DateTime());
        $session->setType($request->get('Type'));
        $em->persist($session);
        $em->flush();

        return $this->json(array('status' => '200'));

    }
}
