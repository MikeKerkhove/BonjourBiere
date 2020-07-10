<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UsersTest extends KernelTestCase
{
    public function getEntity(): User
    {
        return (new User())
            ->setEmail('test@test.com')
            ->setUsername('Tom')
            ->setPassword('12345678');
    }

    public function assertHasErrors(User $user, int $num = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($user);
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
        $user = $this->getEntity()
                            ->setEmail('toto.com')
                            ->setPassword('Oz');
        $this->assertHasErrors($user, 2);
    }
}