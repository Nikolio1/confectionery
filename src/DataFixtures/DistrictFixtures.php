<?php

namespace App\DataFixtures;

use App\Entity\District;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DistrictFixtures
 * 
 * @package App\DataFixtures
 */
class DistrictFixtures extends BaseFixture
{
    /**
     * @var array
     */
    private static $districtName = [
        'District №1',
        'District №2',
        'District №3',
        'District №4',
        'District №5',
        'District №6',
        'District №7',
        'District №8',
        'District №9',
        'District №10',
        'District №11',
        'District №12',
    ];

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        foreach (self::$districtName as $value) {
            $district = new District();

            $district->setName($value);

            $manager->persist($district);
            $manager->flush();

            $this->setReference($value, $district);
        }
    }
}
