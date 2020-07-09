<?php

namespace App\DataFixtures;

use App\Entity\Pictures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PicturesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        $picture = new Pictures();
        $picture->setName("Biere Blonde")
                ->setActive(0)
                ->setLink("https://cache.marieclaire.fr/data/photo/w500_ci/4y/biere-blonde.jpg")
                ->setProposedBy("Mike")
                ->setDate(new \DateTime('2020-07-08'))
                ->setValid(0);
        $manager->persist($picture);
              
        $picture = new Pictures();
        $picture->setName("Biere Brune")
                ->setActive(1)
                ->setLink("https://images.anaca3.com/wp-content/uploads/2018/01/biere-brune-grossir-702x336.jpg")
                ->setProposedBy("John")
                ->setDate(new \DateTime('2020-07-07'))
                ->setValid(1);
        $manager->persist($picture);
        
        $picture = new Pictures();
        $picture->setName("Biere Rousse")
                ->setActive(1)
                ->setLink("https://cache.marieclaire.fr/data/photo/w1000_c17/4y/biere-rousse.jpg")
                ->setProposedBy("Tom")
                ->setDate(new \DateTime('2020-07-06'))
                ->setValid(1);
        $manager->persist($picture);

        $picture = new Pictures();
        $picture->setName("Biere Brune")
                ->setActive(1)
                ->setLink("https://images.anaca3.com/wp-content/uploads/2018/01/biere-brune-grossir-702x336.jpg")
                ->setProposedBy("John")
                ->setDate(new \DateTime('2020-07-05'))
                ->setValid(1);
        $manager->persist($picture);

        $picture->setName("Biere Blonde")
                ->setActive(1)
                ->setLink("https://cache.marieclaire.fr/data/photo/w500_ci/4y/biere-blonde.jpg")
                ->setProposedBy("Mike")
                ->setDate(new \DateTime('2020-07-05'))
                ->setValid(1);
        $manager->persist($picture);
        
        $manager->flush();
    }
}
