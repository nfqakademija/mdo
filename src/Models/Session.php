<?php
/**
 * Created by PhpStorm.
 * User: danilagrobov
 * Date: 11/23/18
 * Time: 3:04 PM
 */

namespace App\Models;


class Session
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $DayOfTheWeek;
    /**
     * @var string
     */
    private $Type;
    /**
     * @var string
     */
    private $From;
    /**
     * @var string
     */
    private $To;
    /**
     * @var int
     */
    private $Price;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDayOfTheWeek()
    {
        return $this->DayOfTheWeek;
    }

    /**
     * @param mixed $DayOfTheWeek
     */
    public function setDayOfTheWeek($DayOfTheWeek): void
    {
        $this->DayOfTheWeek = $DayOfTheWeek;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     */
    public function setType($Type): void
    {
        $this->Type = $Type;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->From;
    }

    /**
     * @param mixed $From
     */
    public function setFrom($From): void
    {
        $this->From = $From;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->To;
    }

    /**
     * @param mixed $To
     */
    public function setTo($To): void
    {
        $this->To = $To;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->Price;
    }

    /**
     * @param mixed $Price
     */
    public function setPrice($Price): void
    {
        $this->Price = $Price;
    }

}