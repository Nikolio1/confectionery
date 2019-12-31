<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CategoryFixtures
 *
 * @package App\DataFixtures
 */
class SubCategoryFixtures extends BaseFixture
{
    /**
     * @var array
     */
    private static $subCategoryName = [
        'Birthday',
        'Wedding',
        'Children\'s party ',
        'Beloved man',
        'Company birthday',
    ];

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(SubCategory::class, 5, function (SubCategory $subCategory, $count) {

            $subCategory->setName($this->faker->randomElement(self::$subCategoryName));
            $subCategory->setCategory($this->getReference(Category::class.'_0'));
        });

        $manager->flush();
    }
}
