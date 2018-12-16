<?php
namespace App\Controller\Rest;

use App\Entity\Customer;
use App\Entity\Session;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends FOSRestController
{

    /**
     * Initialize calendar
     * @Rest\Get("/sessions/{Id}")
     * @param $Id
     * @return View
     */
    public function getCalendar($Id): View
    {

        $sessionRepo = $this->getDoctrine()->getRepository(Session::class)
            ->findBy(['status' => 'free', 'type' => $this->getTypeById($Id)]);

        $freeSessionTimes = [];

        //transform collection data to proper format array
        foreach ($sessionRepo as $value) {
            $freeSessionTimes[$value->getReservedAt('Ymd')] = [
                'free' => 1
            ];
        }

        return View::create($freeSessionTimes, Response::HTTP_OK);
    }

    /**
     * Get free time slot array
     * @Rest\Get("/sessions/{Id}/date/{date}")
     * @param string $Id
     * @param string $date
     * @return View
     * @throws \Exception
     */
    public function getFreeTimesByDate(string $Id, string $date): View
    {
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class)
            ->findBy(['status' => 'free', 'reservedAt' => new \DateTime($date), 'type' => $this->getTypeById($Id)]);

        $freeTimeSlotOfDay = [];

        //transform collection data to proper format array
        foreach ($sessionRepo as $value){
            $freeTimeSlotOfDay[$value->getStartsAt('Hi').'-'.$value->getEndsAt('Hi')] = 1;
        }

        return View::create($freeTimeSlotOfDay, Response::HTTP_OK);
    }

    /**
     * Create an booking
     * @Rest\Post("/sessions")
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function postBookingData(Request $request): View
    {

        //Find slot for booking
        $sessionRepo = $this->getDoctrine()->getRepository(Session::class);
        $customerRepo = $this->getDoctrine()->getRepository(Customer::class);

        $times = explode("-", $request->get('timeslot'));

        $startTime = $this->stringInsert($times[0], ':', 2).':00';
        $endTime   = $this->stringInsert($times[1], ':', 2).':00';

        $session = $sessionRepo
            ->findOneBy(
                [
                'status' => 'free',
                'reservedAt' => new \DateTime($request->get('date')),
                'startsAt' => new \DateTime($startTime),
                'endsAt' => new \DateTime($endTime)
                ]
            );

        if (!$session) {
            throw $this->createNotFoundException(
                'Pavelavai laikas rezervuotas'
            );
        }

        $session->setStatus('reserved');

        if($customer = $customerRepo->findOneBy(['email' => $request->get('guest_email')])){
            $customer->setComment($request->get('guest_comment'));
            $customer->setRegisteredAt(new \DateTime('NOW'));
        }else{
            $customer = New Customer();
            $customer->setFullName($request->get('guest_name').', '.$request->get('guest_surname'));
            $customer->setPhone($request->get('guest_phone'));
            $customer->setEmail($request->get('guest_email'));
            $customer->setComment($request->get('guest_comment'));
            $customer->setRegisteredAt(new \DateTime('NOW'));
        }

        $session->setCustomer($customer);

        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->persist($session);
        $em->flush();

        $message = ['Jusu rezervacija sekminga'];

        return View::create($message, Response::HTTP_OK);
    }

    /**
     * @param $Id
     * @return string
     */
    private function getTypeById($Id){
        $type = '';
        switch ($Id) {
            case 1:
                $type  = 'Adults';
                break;
            case 2:
                $type = 'Kids';
                break;
        }

         return $type;
    }

    /**
     * @param string $str
     * @param string $insertStr
     * @param int $pos
     * @return string
     */
    private function stringInsert(string $str, string $insertStr, int $pos): string
    {
        $str = substr($str, 0, $pos) . $insertStr . substr($str, $pos);
        return $str;
    }
}