<?php

namespace App\Controller;

use App\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationsController extends Controller
{
    public function index()
    {
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);

        return $this->render('views/registrations.html.twig', [
            'page_name' => 'Registrations',
            'registrations' => $sessionRepo->findBy(['status' => 'reserved'])
        ]);
    }


    /**
     * @Route("/cancel-reservation/{id}", name="cancel-reservation", methods={"POST"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function cancelReservation($id){
        $em = $this->getDoctrine()->getManager();
        $session = $this->getDoctrine()->getRepository(Session::class)->find($id);
        if (!$session) {
            throw $this->createNotFoundException(
                'Irasas nerastas duomenu bazeje'
            );
        }

        $session->setStatus('free');
        $session->setCustomer(NULL);

        $em->persist($session);
        $em->flush();

        return $this->json(array('status' => '200', 'message' => 'Rezervacija atsaukta'));
    }
}
