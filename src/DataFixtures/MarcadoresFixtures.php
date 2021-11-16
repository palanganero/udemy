<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Marcador;
use App\Entity\Categoria;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MarcadoresFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager): void
    {
        for ($i=0;$i<10;$i++)
        {
            $marcador= new Marcador();
            $marcador->setNombre("Google ".$i);
            $marcador->setUrl("www.google.com");
            $marcador->setCategoria($this->getReference(CategoriasFixtures::CATEGORIA_INTERNET_REFERENCE));
            $manager->persist($marcador); 
        }
        
        $manager->flush();
    }
    public function getDependencies()
    {
        return [CategoriasFixtures::class];
    }
}
