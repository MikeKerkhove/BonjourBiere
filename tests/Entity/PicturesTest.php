<?php

namespace App\Tests\Entity;

use App\Entity\Pictures;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PicturesTest extends KernelTestCase
{
    public function getEntity(): Pictures
    {
        return (new Pictures())
            ->setName('Bière Blonde')
            ->setActive(1)
            ->setLink('https://cache.marieclaire.fr/data/photo/w500_ci/4y/biere-blonde.jpg')
            ->setProposedBy('Mike')
            ->setDate(new \DateTime())
            ->setValid(1);
    }

    public function assertHasErrors(Pictures $pictures, int $num = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($pictures);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($num, $errors, implode(', ', $messages));
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
        
    }

    public function testInvalidEntity()
    {
        $pictures = $this->getEntity()
                            ->setName('beer')
                            ->setLink('google.com')
                            ->setProposedBy('Oz');
        $this->assertHasErrors($pictures, 3);
    }
}