<?php
/**
 * Created by PhpStorm.
 * User: ovidijus
 * Date: 18.12.7
 * Time: 12.10
 */

namespace App\Service;


class SessionFactory
{

    /**
     * @param string $startDate
     * @param int $repeatWeeks
     * @return array
     * @throws \Exception
     */
    public function repeatPerWeeks(string $startDate, int $repeatWeeks): array
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