<?php
/**
 * Created by PhpStorm.
 * User: danilagrobov
 * Date: 11/23/18
 * Time: 12:24 AM
 */

namespace App\Repositories;


use App\Models\Registration;

class RegistrationsRepository
{

    public function getRegistrations(): array
    {
        return $this->LoadData();
    }
    public function addRegistrations(){

    }
    private function LoadData(){
        $result = [];
        $data = json_decode(
            file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Db' . DIRECTORY_SEPARATOR . 'Data.json'),
            true
        );
        foreach ($data as $item) {
            $record = new Registration();
            $record->setDate($item['Date']);
            $record->setId($item['id']);
            $record->setName($item['FullName']);
            $record->setEmail($item['Email']);
            $record->setMnumber($item['MobilePhone']);
            $record->setStatus($item['Status']);
            $result[] = $record;
        }
        return $result;
    }
}