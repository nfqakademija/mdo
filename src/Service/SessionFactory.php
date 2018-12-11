<?php

namespace App\Service;

use App\Entity\Session;
use Symfony\Component\HttpFoundation\Request;

class SessionFactory
{

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function createRepeated(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repeat = $request->get("repeatFor");

        if (isset($repeat)){
            foreach ($this->repeatPerWeeks($request->get('date'), $request->get("repeatFor")) as $key => $date) {
                $session = new Session();
                $session->setStartsAt(new \DateTime($request->get('from')));
                $session->setEndsAt(new \DateTime($request->get('to')));
                $session->setReservedAt(new \DateTime($date->format('Y-m-d')));
                $session->setType($request->get('type'));
                $session->setStatus('free');
                $em->persist($session);
                $em->flush();
            }
            }else{
                $session = new Session();
                $session->setStartsAt(new \DateTime($request->get('from')));
                $session->setEndsAt(new \DateTime($request->get('to')));
                $session->setReservedAt(new \DateTime($request->get('date')));
                $session->setType($request->get('type'));
                $session->setStatus('free');
                $em->persist($session);
                $em->flush();
            }
    }


    /**
     * @param string $startDate
     * @param int $repeatWeeks
     * @return array
     * @throws \Exception
     */
    private function repeatPerWeeks(string $startDate, int $repeatWeeks): array
    {
        $startDate = $startDate;
        $startDateDateObj = new \DateTime($startDate);
        $startDateDateObj = $startDateDateObj->modify("+$repeatWeeks weeks");
        $repeatEndDate = $startDateDateObj->format('Y-m-d');

        $step  = 1;
        $unit  = 'W';

        $repeatStart = new \DateTime($startDate);
        $repeatEnd   = new \DateTime($repeatEndDate);
        $interval = new \DateInterval("P{$step}{$unit}");
        $period   = new \DatePeriod($repeatStart, $interval, $repeatEnd);

        return $period;
    }
}
