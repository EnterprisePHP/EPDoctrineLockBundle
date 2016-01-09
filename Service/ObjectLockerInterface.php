<?php

namespace EP\DoctrineLockBundle\Service;

use EP\DoctrineLockBundle\Params\ObjectLockParams;

interface ObjectLockerInterface
{
    public function lock($object, $lockType = ObjectLockParams::FULL_LOCK);

    public function unlock($object, $lockType = ObjectLockParams::FULL_LOCK);

    public function switchLock($object, $lockType = ObjectLockParams::FULL_LOCK);

    public function isLocked($object, $lockType = ObjectLockParams::FULL_LOCK);
}
