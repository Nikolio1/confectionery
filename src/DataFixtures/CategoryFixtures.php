<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
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
    public static $categories = [
        'Festive cakes',
        'Cakes for every day',
        'Weighted cakes and rolls ',
        'Elite cakes',
        'High Storage Products',
        'Cake sets',
    ];

    /**
     * @var array
     */
    public static $subCategories = [
        'Birthday',
        'Wedding',
        'Children\'s party',
        'Beloved man',
        'Company Birthday',
    ];



    /**
     * @param ObjectManager $manager
     */
    public function loadData(ObjectManager $manager)
    {
        foreach (self::$categories as $valueCategory) {

            $category = new Category();

            if ($valueCategory != 'Elite cakes') {
                $category->setName($valueCategory);
                $category->setIsElite(false);
                $manager->persist($category);

                $this->setReference($valueCategory, $category);

                $manager->flush();

            } else {
                $category->setName($valueCategory);
                $category->setIsElite( true);
                $manager->persist($category);

                $this->setReference('parentCategory', $category);
                $manager->flush();
            }
        }

        foreach (self::$subCategories as $valueSubCategory) {
            $category = new Category();
            $category->setName($valueSubCategory);
            $category->setIsElite(false);
            $category->setParentCategory($this->getReference('parentCategory'));
            $manager->persist($category);

            $this->setReference($valueSubCategory, $category);
            $manager->flush();
        }


    }
}

