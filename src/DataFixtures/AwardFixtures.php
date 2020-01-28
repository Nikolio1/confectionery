<?php

namespace App\DataFixtures;

use App\Entity\Award;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AwardFixtures
 *
 * @package App\DataFixtures
 */
class AwardFixtures extends BaseFixture
{
    /**
     * @var array
     */
    private static $awardName = [
        'Factory of the year',
        'Product of the year',
        'The world\'s largest cake',
        'The darkest chocolate',
    ];

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Award::class, 4,function (Award $award, $count) {

            $award->setName($this->faker->randomElement(self::$awardName))
                  ->setAnnotation($this->faker->text(50))
                  ->setText($this->faker->realText($maxNbChars = 2000, $indexSize = 2))
                  ->setImageName('award1.jpg');
        });

        $manager->flush();

    }
}
