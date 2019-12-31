<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class NewsFixtures
 *
 * @package App\DataFixtures
 */
class NewsFixtures extends BaseFixture
{
    /**
     * @var array
     */
    private static $newsImages = [
        'news1.jpg',
        'news2.jpg',
        'news3.jpg',
        'news4.jpg',
        'news5.jpg',
    ];

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(News::class, 10,function (News $news, $count) {

        $news->setHeading($this->faker->text(5))
             ->setAnnotation($this->faker->text(25))
             ->setDateCreation($this->faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now', $timezone = null))
             ->setImageName($this->faker->randomElement(self::$newsImages))
             ->setText($this->faker->realText($maxNbChars = 2000, $indexSize = 2));
        });

        $manager->flush();

    }
}
