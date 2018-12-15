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
    public function index(SessionFactory $sessionFactory)
    {
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);

        return $this->render('views/add-time.html.twig', [
            'page_name' => 'Add-Time',
            'sessions'=> $sessionFactory->formatSessionsArray($sessionRepo->findAll())
        ]);
    }

    /**
     * @Route("/sessions", name="create-session", methods={"POST"})
     * @param SessionFactory $sessionFactory
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function create(SessionFactory $sessionFactory, Request $request)
    {
        $sessionFactory->createSessions($request);

        if(!empty($sessionFactory->validationMessages)){
            return $this->json($sessionFactory->validationMessages);
        }else {
            return $this->json(array('message' => 'Sekmingai prideta'));
        }
    }

    /**
     * @Route("/sessions/{id}", name="get-sessions", methods={"GET"})
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
     * @Route("/sessions/{id}", name="edit-sessions", methods={"PUT"})
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
     * @Route("/sessions/{id}", name="delete-sessions", methods={"DELETE"})
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

    /**
     * @Route("/sessions/{hash}", name="delete-sessionsByHash", methods={"DELETEHASH"})
     * @param $hash
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteWithHash($hash)
    {
        $em = $this->getDoctrine()->getManager();
        $sessions = $this->getDoctrine()->getRepository(Session::class)->findByHash($hash);
        if (!$sessions) {
            throw $this->createNotFoundException(
                'Irasas nerastas duomenu bazeje'
            );
        }
        foreach ($sessions as $session )
        {
            $em->remove($session);
        }
        $em->flush();

        return $this->json(array('status' => '200', 'message' => 'Istrinta sekmingai'));
    }
}
