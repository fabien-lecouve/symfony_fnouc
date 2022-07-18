<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     *
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ( $i=1; $i<=10; $i++ )
        {
            $category = new Category();
            $category->setName($this->faker->word());
            $manager->persist($category);
            for ( $j=1; $j<=10; $j++ )
            {
                $product = new Product();
                $product->setName($this->faker->word())
                    ->setUnitPrice($this->faker->randomNumber(3, false))
                    ->setDescription($this->faker->sentence(10))
                    ->setDisponibility($this->faker->numberBetween(0, 1))
                    ->setCategory($category);
                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
