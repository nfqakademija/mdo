<?php

namespace App\DataFixtures;

use App\Entity\WeekDays;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

         $manager->persist((new WeekDays())
                ->setDayName('Monday')
                ->setDayNo(1)
         );
         $manager->persist((new WeekDays())
                ->setDayName('Tuesday')
                ->setDayNo(2)
         );
         $manager->persist((new WeekDays())
                ->setDayName('Wednesday')
                ->setDayNo(3)
         );
         $manager->persist((new WeekDays())
                ->setDayName('Thursday')
                ->setDayNo(4)
         );
         $manager->persist((new WeekDays())
                ->setDayName('Friday')
                ->setDayNo(5)
         );
         $manager->persist((new WeekDays())
                ->setDayName('Saturday')
                ->setDayNo(6)
         );
         $manager->persist((new WeekDays())
                ->setDayName('Sunday')
                ->setDayNo(7)
         );

         $manager->flush();


    }
}
