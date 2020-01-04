<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ShopFixtures
 *
 * @package App\DataFixtures
 */
class ShopFixtures extends BaseFixture
{
    /**
     * @var array
     */
    private static $shopName = [
        'Shop №1',
        'Shop №2',
        'Shop №3',
        'Shop №4',
        'Shop №5',
        'Shop №6',
        'Shop №7',
        'Shop №8',
        'Shop №9',
        'Shop №10',
        'Shop №11',
        'Shop №12',
    ];

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
        $this->createMany(Shop::class, 30,function (Shop $shop, $count) {

            $shop->setName('shop№'.(rand(1,100)))
                 ->setAddress($this->faker->address)
                 ->setMapLink($this->faker->text(30))
                 ->setIsBranded($this->faker->boolean(30))
                 ->setDistrict($this->getReference($this->faker->randomElement(self::$districtName)));
        });

        $manager->flush();
    }
}
