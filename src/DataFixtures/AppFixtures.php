<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Store;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    
    //private UserPasswordEncoderInterface $passwordEncoder;


    private  $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
        $user = new User();
        $user->setEmail($faker->email)
            ->setPassword($this->passwordEncoder->encodePassword($user, 'password'))
            ->setRoles(['ROLE_PARA']);
            $store = new Store();
            $store->setName($faker->company)->setPhone($faker->numerify('########'))->setEmail($faker->companyEmail)->setUser($user);
        for ($j = 0; $j < 100; $j++) {
            $product = new Product();
            $product->setName($faker->city)
                ->setDescription($faker->paragraph('5'))
                ->setQuantity($faker->numerify('###'))
                ->setPrice($faker->randomFloat())->setStore($store);
            $manager->persist($product);
        }
        $manager->persist($user);
        $manager->persist($store);
        }
        $manager->flush();
    }
}
