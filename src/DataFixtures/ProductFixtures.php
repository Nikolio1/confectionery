<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\News;
use App\Entity\Product;
use App\Entity\SubCategory;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ProductFixtures
 *
 * @package App\DataFixtures
 */
class ProductFixtures extends BaseFixture
{

    /**
     * @var array
     */
    public static $categories = [
        'Festive cakes',
        'Cakes for every day',
        'Weighted cakes and rolls ',
        'High Storage Products',
        'Cake sets',
        'Birthday',
        'Wedding',
        'Children\'s party',
        'Beloved man',
        'Company Birthday',
    ];


    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Product::class, 50,function (Product $product, $count) {

            $product->setName($this->faker->text(10))
                    ->setDescription($this->faker->realText($maxNbChars = 2000, $indexSize = 2))
                    ->setAnnotation($this->faker->text(25))
                    ->setIsNewProduct(false)
                    ->setImageName('product1.jpg')
                    ->setWeight($this->faker->numberBetween(1,5))
                    ->setCategory($this->getReference($this->faker->randomElement(self::$categories)));
        });

        $manager->flush();
    }
}