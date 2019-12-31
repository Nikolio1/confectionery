<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CategoryFixtures
 *
 * @package App\DataFixtures
 */
class CategoryFixtures extends BaseFixture
{
    /**
     * @var array
     */
    public static $categoryName = [
        'Festive cakes',
        'Cakes for every day',
        'Weighted cakes and rolls ',
        'Elite cakes',
        'High Storage Products ',
        'Cake sets ',
    ];


    /**
     * @param ObjectManager $manager
     */
    public function loadData(ObjectManager $manager)
    {

        $this->createMany(Category::class, 5,function (Category $category, $count) {

            $category
                ->setName(
                    $this->faker->randomElement(self::$categoryName)
                )
                ->setIsElite(
                    $this->faker->boolean(20)
                );
        });

        $manager->flush();
    }
}
