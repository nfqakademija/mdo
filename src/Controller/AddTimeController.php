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

        return $this->render('views/add-time.html.twig', [
            'page_name' => 'Add-Time',
            'sessions'=> $sessionRepo->findAll()
        ]);
    }


    /**
     * @Route("/time-slot-submit", name="submit-add-slot", methods={"POST"})
     * @param Request $request
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $startDate = new \DateTime('Y-m-d');
        $repeatEndDate = $startDate->modify("+$request->get('repeatFor') week"); //'2018-12-31';repeatFor

        $step  = 1;
        $unit  = 'W';
        $repeatStart = new \DateTime($startDate);
        $repeatEnd   = new \DateTime($repeatEndDate);
        $interval = new \DateInterval("P{$step}{$unit}");
        $period   = new \DatePeriod($repeatStart, $interval, $repeatEnd);


        foreach ($period as $key => $date) {
            $session = new Session();
            $session->setDay($request->get('Day'));
            $session->setStartsAt(new \DateTime($request->get('From').':00'));
            $session->setEndsAt(new \DateTime($request->get('To').':00' ));
            $session->setReservedAt(new \DateTime($date->format('Y-m-d')));
            $session->setType($request->get('Type'));
            $session->setStatus('free');
            $em->persist($session);
            $em->flush();
        }

        return $this->json(array('status' => '200'));

    }

    /**
     * @Route("/time-slot-edit/{id}", name="submit-edit-slot", methods={"GET"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getEdit($id)
    {
        $session = $this->getDoctrine()->getRepository(Session::class)->find($id);

        return $this->json(array($session));
    }


    /**
     * @Route("/time-slot-edit/{id}", name="submit-edit-slot", methods={"POST"})
     * @param $id
     * @param Request $request
     * @throws \Exception
     */
    public function edit($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getDoctrine()->getRepository(Session::class)->find($id);

        $session->setDay($request->get('Day'));
        $session->setStartsAt(new \DateTime($request->get('From').':00'));
        $session->setEndsAt(new \DateTime($request->get('To').':00' ));
        $session->setReservedAt(new \DateTime($date->format('Y-m-d')));
        $session->setType($request->get('Type'));

        $em->persist($session);
        $em->flush();

    }


    /**
     * @Route("/time-slot-delete/{id}", name="submit-delete-slot", methods={"POST"})
     * @param $id
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getDoctrine()->getRepository(Session::class)->find($id);

        $em->remove($session);
        $em->flush();
    }


    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        // Nereikalingas metodas
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);
        echo '<pre>';
        print_r($sessionRepo->checkSlotFree('2018-12-03', '15:00:00', '16:30:00'));
        die();
    }
}
