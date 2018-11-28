<?php
/**
 * Created by PhpStorm.
 * User: danilagrobov
 * Date: 11/23/18
 * Time: 12:24 AM
 */

namespace App\Repositories;



use App\Models\Session;

class SessionRepository implements Repository
{
    public function getData(): array
    {
        return $this->LoadData();
    }
    public function setData($registration): void
    {

    }


    private function LoadData(){
        $result = [];
        $data = json_decode(
            file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Db' . DIRECTORY_SEPARATOR . 'Sessions.json'),
            true
        );
        foreach ($data as $item) {
            $record = new Session();
            $record->setDayOfTheWeek($item['DayOfTheWeek']);
            $record->setId($item['id']);
            $record->setFrom($item['From']);
            $record->setTo($item['To']);
            $record->setPrice($item['Price']);
            $record->setType($item['Type']);
            $result[] = $record;
        }
        return $result;
    }
}