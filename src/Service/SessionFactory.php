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
        $sessionNumber = 0;
        $hash = uniqid();
        $requestData = json_decode($request->getContent(), true);
        foreach ($requestData as $requestItems) {
            foreach ($requestItems as $requestItem) {
                $this->validate($requestItem,$sessionNumber);
                if(sizeof($this->validationMessages) <= 0) {
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
                $sessionNumber ++;
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
    private function create($from, $to, $date, $type, $hash): Session
    {
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

    public function validate( $session, int  $id)
    {
        if((new \DateTime($session['from'])) >= (new \DateTime($session['to']))){
            array_push($this->validationMessages,array('timeIndex'=>$id,"errorText"=>"Session can't end earlier than it starts!","errorElement"=>"To"));
        }
        if($session['from'] == ''){
            array_push($this->validationMessages,array('timeIndex'=>$id,"errorText"=>"Input can not be empty!","errorElement"=>"From"));
        }
        if($session['to'] == ''){
            array_push($this->validationMessages,array('timeIndex'=>$id,"errorText"=>"Input can not be empty!","errorElement"=>"To"));
        }
        if(isset($session['repeatFor']) && $session['repeatFor'] > 50){
            array_push($this->validationMessages,array('timeIndex'=>$id,"errorText"=>"You can not repeat for more than 50 weeks!","errorElement"=>"repeatEveryInput"));
        }
        $pattern='~^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$~';

        if(!preg_match($pattern, $session['from'], $match)){
            array_push($this->validationMessages,array('timeIndex'=>$id,"errorText"=>"Invalid input, the time format should be HH:MM!","errorElement"=>"From"));
        }
        if(!preg_match($pattern, $session['to'], $match)){
            array_push($this->validationMessages,array('timeIndex'=>$id,"errorText"=>"Invalid input, the time format should be HH:MM!","errorElement"=>"To"));
        }

    }

    /**
     * @return array
     */
    public function getValidationMessages(): array
    {
        return $this->validationMessages;
    }

    /**
     * @param array $validationMessages
     */
    public function setValidationMessages(array $validationMessages): void
    {
        $this->validationMessages = $validationMessages;
    }

    public function formatSqlResult( $sqlArr ){

        $format = function ($session)
        {
            return array(
                "from" => (new \DateTime($session['starts_at']))->format('H:i'),
                "to" => (new \DateTime($session['ends_at']))->format('H:i'),
                "type" => $session['type'],
                "id" => $session['id'],
                "date" => (new \DateTime($session['reserved_at']))->format('Y-m-d'),
                "hash" => $session['hash']
            );
        };
        $formatedArray = array_map($format, $sqlArr);
        return $formatedArray;
    }
}
