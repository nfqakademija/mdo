<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repositories\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\SessionFactory;

class AddTimeController extends AbstractController
{
    public function index(SessionFactory $sessionFactory)
    {
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);
        $year = (new \DateTime())->format('Y');
        return $this->render('views/add-time.html.twig', [
            'page_name' => 'Add-Time',
            'sessions'=> $sessionRepo->findAllByYear($year)
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

        $data = json_decode($request->getContent(), true);;
        $sessionFactory->createSessions($request);

        if(!empty($sessionFactory->validationMessages)){
            return JsonResponse::create($sessionFactory->validationMessages);
        }else {
            return JsonResponse::create('Sekmingai');
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
     * @Route("/sessions", name="edit-session-id", methods={"EDITID"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function editById(Request $request,SessionFactory $sessionFactory)
    {
        $em = $this->getDoctrine()->getManager();
        $sessionsEdited = json_decode($request->getContent(), true);
        $sessionNumber = 0;
        foreach ($sessionsEdited as $sessionEdited) {
            $sessionFactory->validate($sessionEdited,$sessionNumber);
            if(sizeof($sessionFactory->getValidationMessages()) <= 0) {
                $sessionToEdit = $this->getDoctrine()->getRepository(Session::class)->find($sessionEdited['id']);

                $sessionToEdit->setStartsAt(new \DateTime($sessionEdited['from']));
                $sessionToEdit->setEndsAt(new \DateTime($sessionEdited['to']));
                $sessionToEdit->setType($sessionEdited['type']);
                $sessionToEdit->setHash(uniqid());

                $em->persist($sessionToEdit);
            }
            $sessionNumber++;
        }
        if(sizeof($sessionFactory->getValidationMessages()) <= 0){
            $em->flush();
            return JsonResponse::create('Sekmingai');
        }
        else{
            return JsonResponse::create($sessionFactory->validationMessages);
        }

    }
    /**
     * @Route("/sessions", name="edit-session-hash", methods={"EDITHASH"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function editByHash(Request $request,SessionFactory $sessionFactory)
    {
        $em = $this->getDoctrine()->getManager();
        $sessionsEdited = json_decode($request->getContent(), true);
        $sessionNumber = 0;
        foreach ($sessionsEdited as $sessionEdited) {
            $sessionFactory->validate($sessionEdited,$sessionNumber);
            if(sizeof($sessionFactory->getValidationMessages()) <= 0) {
                $sessionsToEdit = $this->getDoctrine()->getRepository(Session::class)->findByHash($sessionEdited['hash']);

                if (!$sessionsToEdit) {
                    throw $this->createNotFoundException(
                        'Irasas nerastas duomenu bazeje'
                    );
                }
                foreach ($sessionsToEdit as $sessionToEdit) {
                    $sessionToEdit->setStartsAt(new \DateTime($sessionEdited['from']));
                    $sessionToEdit->setEndsAt(new \DateTime($sessionEdited['to']));
                    $sessionToEdit->setType($sessionEdited['type']);
                    $em->persist($sessionToEdit);
                }
            }
            $sessionNumber++;
        }
        if(sizeof($sessionFactory->getValidationMessages()) <= 0){
            $em->flush();
            return JsonResponse::create('Sekmingai');
        }
        else{
            return JsonResponse::create($sessionFactory->validationMessages);
        }
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
    /**
     * @Route("/sessions/{year}", name="get-yearSessions", methods={"GETYEAR"})
     * @param $year
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getYear($year)
    {
        $sessions = $this->getDoctrine()->getRepository(Session::class)->findAllByYear($year);

        return $this->json(array('status' => '200', 'sessions' => $sessions));
    }
}
