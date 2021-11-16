<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categoria;
class CategoriasFixtures extends Fixture
{
    public const CATEGORIA_INTERNET_REFERENCE ='categoria-internet';
    public function load(ObjectManager $manager): void
    {
        $categoria= new Categoria();
        $categoria->setNombre("Internet");
        $categoria->setColor("red");
        $manager->persist($categoria);
        $manager->flush();
        $this->addReference(self::CATEGORIA_INTERNET_REFERENCE,$categoria);
    }
}
