<?php

namespace EP\DoctrineLockBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Doctrine\ORM\EntityManager;
use EP\DoctrineLockBundle\Params\ObjectLockerParams;

class ObjectLocker
{
    /** @var EntityManager */
    private $em;

    /**
     * ObjectLocker constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function lock($object, $lockType = ObjectLockerParams::FULL_LOCK)
    {
    }

    public function unlock($object, $lockType = ObjectLockerParams::FULL_LOCK)
    {
    }

    public function switchLock($object, $lockType = ObjectLockerParams::FULL_LOCK)
    {
    }
}
