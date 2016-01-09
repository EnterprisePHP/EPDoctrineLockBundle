<?php

namespace EP\DoctrineLockBundle\Traits;

/**
 * Class LockableTrait
 * @package EP\DoctrineLockBundle\Traits
 */
trait LockableTrait
{
    /**
     * @var bool
     */
    protected $updateLocked = false;

    /**
     * @var bool
     */
    protected $deleteLocked = false;

    /**
     * @return boolean
     */
    public function isUpdateLocked()
    {
        return $this->updateLocked;
    }

    /**
     * @param boolean $updateLocked
     * @return $this
     */
    public function setUpdateLocked($updateLocked)
    {
        $this->updateLocked = $updateLocked;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isDeleteLocked()
    {
        return $this->deleteLocked;
    }

    /**
     * @param boolean $deleteLocked
     * @return $this
     */
    public function setDeleteLocked($deleteLocked)
    {
        $this->deleteLocked = $deleteLocked;

        return $this;
    }
}
