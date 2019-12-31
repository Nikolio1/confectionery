<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\News;
use App\Entity\Product;
use App\Entity\SubCategory;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class NewsFixtures
 *
 * @package App\DataFixtures
 */
class ProductFixtures extends BaseFixture
{


    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Product::class, 10,function (Product $product, $count) {

            $product->setName($this->faker->text(5))
                ->setDescription($this->faker->realText($maxNbChars = 2000, $indexSize = 2))
                ->setAnnotation($this->faker->text(25))
                ->setIsNewProduct(false)
                ->setImageName('product1.jpg')
                ->setSubCategory($this->getReference(SubCategory::class.'_0'))
                ->setCategory($this->getReference(Category::class.'_2'));
        });

        $manager->flush();

    }
}
