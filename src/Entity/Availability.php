<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvailabilityRepository")
 */
class Availability
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\WeekDays", mappedBy="id")
     */
    private $day_of_week;


    /**
     * @ORM\Column(type="time")
     */
    private $start_time;

    /**
     * @ORM\Column(type="time")
     */
    private $end_time;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $slot_space;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $slot_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayOfWeek(): ?int
    {
        return $this->day_of_week;
    }

    public function setDayOfWeek(int $day_of_week): self
    {
        $this->day_of_week = $day_of_week;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getSlotSpace(): ?string
    {
        return $this->slot_space;
    }

    public function setSlotSpace(string $slot_space): self
    {
        $this->slot_space = $slot_space;

        return $this;
    }

    public function getSlotDate(): ?\DateTimeInterface
    {
        return $this->slot_date;
    }

    public function setSlotDate(?\DateTimeInterface $slot_date): self
    {
        $this->slot_date = $slot_date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

}
