<?php

namespace App\Handlers;

use Doctrine\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BaseHandler
 *
 * @package App\Handlers
 */
class BaseHandler
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * BaseHandler constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $object
     *
     * @return ObjectRepository
     */
    public function getRepository($object)
    {
        return $this->em->getRepository($object);
    }

    /**
     * @param $object
     *
     * @return mixed
     */
    public function saveObject($object)
    {
        $this->em->persist($object);
        $this->em->flush();

        return $object;
    }

    /**
     * @param $object
     *
     * @return mixed
     */
    public function removeObject($object)
    {
        $this->em->remove($object);
        $this->em->flush();

        return $object;
    }
}