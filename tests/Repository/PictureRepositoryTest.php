<?php

namespace App\Tests\Repository;

use App\Repository\PicturesRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PicturesRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    public function testCount()
    {
        self::bootKernel();
        $this->loadFixtureFiles([
            __DIR__ . '/PictureRepositoryTestFixtures.yaml'
        ]);
        $pictures = self::$container->get(PicturesRepository::class)->count([]);
        $this->assertEquals(20, $pictures);
    }
}