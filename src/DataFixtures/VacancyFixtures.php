<?php

namespace App\DataFixtures;

use App\Entity\Vacancy;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class VacancyFixtures\
 *
 * @package App\DataFixtures
 */
class VacancyFixtures extends BaseFixture
{
    /**
     * @var array
     */
    private static $vacancies= [
        'Workshop master',
        'Confectioner',
    ];

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        foreach (self::$vacancies as $value) {
            $vacancy = new Vacancy();

            $vacancy->setName($value)
                ->setDescription($this->faker->text(200));

            $manager->persist($vacancy);
        }

        $manager->flush();
    }
}
