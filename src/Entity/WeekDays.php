<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WeekDaysRepository")
 */
class WeekDays
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Availability", inversedBy="day_of_week")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $day_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $day_no;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayName(): ?string
    {
        return $this->day_name;
    }

    public function setDayName(string $day_name): self
    {
        $this->day_name = $day_name;

        return $this;
    }

    public function getDayNo(): ?int
    {
        return $this->day_no;
    }

    public function setDayNo(int $day_no): self
    {
        $this->day_no = $day_no;

        return $this;
    }
}
