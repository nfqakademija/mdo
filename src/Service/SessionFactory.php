<?php

namespace App\Service;

use App\Entity\Session;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class SessionFactory
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var array
     */
    public $validationMessages = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function createSessions(Request $request)
    {
        $hash = uniqid();
        $requestData = json_decode($request->getContent(), true);
        foreach ($requestData as $requestItems) {
            foreach ($requestItems as $requestItem) {
                if (isset($requestItem['repeatFor'])) {
                    foreach ($this->repeatPerWeeks($requestItem['date'], $requestItem['repeatFor']) as $key => $date) {
                        $this->create(
                            new \DateTime($requestItem['from']),
                            new \DateTime($requestItem['to']),
                            new \DateTime($date->format('Y-m-d')),
                            $requestItem['type'],
                            $hash
                        );
                    }
                } else {
                    $this->create(
                        new \DateTime($requestItem['from']),
                        new \DateTime($requestItem['to']),
                        new \DateTime($requestItem['date']),
                        $requestItem['type'],
                        $hash
                    );
                }
            }
        }
    }

    /**
     * @param $from
     * @param $to
     * @param $date
     * @param $type
     * @param $hash
     * @return Session
     * @throws \Exception
     */
    private function create($from, $to, $date, $type, $hash): ?Session
    {
        if(!empty((array) $this->validateDateTimeEmpty($from, $to, $date, $type))){
            $this->validationMessages[] = $this->validateDateTimeEmpty($from, $to, $date, $type);
            return null;
        }else{
            $session = new Session();
            $session->setStartsAt($from);
            $session->setEndsAt($to);
            $session->setReservedAt($date);
            $session->setType($type);
            $session->setStatus('free');
            $session->setHash($hash);

            $this->em->persist($session);
            $this->em->flush();

            return $session;
        }
    }

    /**
     * @param string $startDate
     * @param int $repeatWeeks
     * @return array
     * @throws \Exception
     */
    private function repeatPerWeeks(string $startDate, int $repeatWeeks): object
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

    /**
     * @param $from
     * @param $to
     * @param $date
     * @param $type
     * @return object|null
     */
    private function validateDateTimeEmpty($from, $to, $date, $type): ?object
    {
        $session = $this->em->getRepository(Session::class)->findOneBy(
            [
                'reservedAt' => $date,
                'startsAt' => $from,
                'endsAt' => $to,
                'type' =>$type
            ]
        );

        return $session;
    }
}
