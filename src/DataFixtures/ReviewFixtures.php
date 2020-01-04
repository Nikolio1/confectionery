<?php

namespace App\DataFixtures;

use App\Entity\Award;
use App\Entity\Review;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ReviewFixtures
 *
 * @package App\DataFixtures
 */
class ReviewFixtures extends BaseFixture
{


    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Review::class, 10,function (Review $review, $count) {

            $review->setName($this->faker->name)
                  ->setEmail($this->faker->email)
                  ->setText($this->faker->realText($maxNbChars = 200, $indexSize = 2))
                  ->setIsValidated($this->faker->boolean(70));
        });

        $manager->flush();

    }
}
