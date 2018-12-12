<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repositories\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\SessionFactory;

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
     * @param SessionFactory $sessionFactory
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function create(SessionFactory $sessionFactory, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($sessionFactory->repeatPerWeeks($request->get('date'), $request->get("repeatFor")) as $key => $date) {
            $session = new Session();
            $session->setStartsAt(new \DateTime($request->get('from')));
            $session->setEndsAt(new \DateTime($request->get('to')));
            $session->setReservedAt(new \DateTime($date->format('Y-m-d')));
            $session->setType($request->get('type'));
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
        if (!$session) {
            throw $this->createNotFoundException(
                'Irasas nerastas duomenu bazeje'
            );
        }

        return $this->json(array($session));
    }

    /**
     * @Route("/time-slot-edit/{id}", name="submit-edit-slot", methods={"POST"})
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function edit($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getDoctrine()->getRepository(Session::class)->find($id);
        if (!$session) {
            throw $this->createNotFoundException(
                'Irasas nerastas duomenu bazeje'
            );
        }

        $session->setDay($request->get('Day'));
        $session->setStartsAt(new \DateTime($request->get('From').':00'));
        $session->setEndsAt(new \DateTime($request->get('To').':00' ));
        $session->setReservedAt(new \DateTime($date->format('Y-m-d')));
        $session->setType($request->get('Type'));

        $em->persist($session);
        $em->flush();

        return $this->json(array('status' => '200', 'message' => 'Atnaujinta sekmingai'));
    }

    /**
     * @Route("/time-slot-delete/{id}", name="submit-delete-slot", methods={"POST"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getDoctrine()->getRepository(Session::class)->find($id);
        if (!$session) {
            throw $this->createNotFoundException(
                'Irasas nerastas duomenu bazeje'
            );
        }

        $em->remove($session);
        $em->flush();

        return $this->json(array('status' => '200', 'message' => 'Istrinta sekmingai'));
    }
}
