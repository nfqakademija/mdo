<?php

namespace App\Controller;

use App\Entity\Discount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DiscountController extends Controller
{
    /**
     * @Route("/admin/discount", name="index-discount", methods={"GET"})
     */
    public function index()
    {
        $discountRepo = $this->getDoctrine()->getRepository(Discount::class);

        return $this->render('views/discount.html.twig', [
            'page_name' => 'Discount',
            'discounts' => $discountRepo->findAll()
        ]);
    }

    /**
     * @Route("/discount", name="create-discount", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $discount = new Discount();
        $discount->setName($request->get('discount_name'));
        $discount->setCode('zombie');
        $discount->setAmount($request->get('amount'));

        $em->persist($discount);
        $em->flush();

        return $this->json(array('status' => '200', 'message' => 'Nuolaida prideta sekmingai'));
    }


    /**
     * @Route("/discount/{id}", name="get-discount", methods={"GET"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getEdit($id)
    {
        $discount = $this->getDoctrine()->getRepository(Discount::class)->find($id);
        if (!$discount) {
            throw $this->createNotFoundException(
                'Irasas nerastas duomenu bazeje'
            );
        }

        return $this->json(array($discount));
    }

    /**
     * @Route("/discount/{id}", name="edit-discount-id", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editById($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $discount = $this->getDoctrine()->getRepository(Discount::class)->find($id);
        if (!$discount) {
            throw $this->createNotFoundException(
                'Irasas nerastas duomenu bazeje'
            );
        }

        $discount->setName($request->get('discount_name'));
        $discount->setAmount($request->get('amount'));

        $em->persist($discount);
        $em->flush();

        return $this->json(array('status' => '200', 'message' => 'Pakeista sekmingai'));
    }

    /**
     * @Route("/discount/{id}", name="delete-discount", methods={"DELETE"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $discount = $this->getDoctrine()->getRepository(Discount::class)->find($id);
        if (!$discount) {
            throw $this->createNotFoundException(
                'Irasas nerastas duomenu bazeje'
            );
        }

        $em->remove($discount);
        $em->flush();

        return $this->json(array('status' => '200', 'message' => 'Istrinta sekmingai'));
    }
}
