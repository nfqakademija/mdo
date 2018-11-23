<?php
/**
 * Created by PhpStorm.
 * User: danilagrobov
 * Date: 11/23/18
 * Time: 3:01 PM
 */

namespace App\Repositories;


interface Repository
{
    public function getData();
    public function setData($data);
}