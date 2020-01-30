<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 *
 * @package App\DataFixtures
 */
class UserFixtures extends BaseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
            $user = new User();
            $user->setEmail('user1@mail.ru')
                  ->setFirstName($this->faker->firstName)
                  ->setPassword($this->passwordEncoder->encodePassword(
                      $user,
                      '1234'
                  ));

            $manager->persist($user);
            $manager->flush();



            $user = new User();
            $user->setEmail('admin1@mail.ru')
                ->setFirstName($this->faker->firstName)
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    '1234'
                ))
                ->setRoles(['ROLE_ADMIN']);

            $manager->persist($user);
            $manager->flush();

    }
}
