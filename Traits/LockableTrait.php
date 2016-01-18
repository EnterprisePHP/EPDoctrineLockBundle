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
     * @var string
     */
    protected $updateLockedBy;

    /**
     * @var \DateTime
     */
    protected $updateLockedTime;

    /**
     * @var bool
     */
    protected $deleteLocked = false;

    /**
     * @var string
     */
    protected $deleteLockedBy;

    /**
     * @var \DateTime
     */
    protected $deleteLockedTime;

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

    /**
     * @return string
     */
    public function getUpdateLockedBy()
    {
        return $this->updateLockedBy;
    }

    /**
     * @param string $updateLockedBy
     * @return $this
     */
    public function setUpdateLockedBy($updateLockedBy)
    {
        $this->updateLockedBy = $updateLockedBy;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateLockedTime()
    {
        return $this->updateLockedTime;
    }

    /**
     * @param \DateTime $updateLockedTime
     * @return $this
     */
    public function setUpdateLockedTime($updateLockedTime)
    {
        $this->updateLockedTime = $updateLockedTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeleteLockedBy()
    {
        return $this->deleteLockedBy;
    }

    /**
     * @param string $deleteLockedBy
     * @return $this
     */
    public function setDeleteLockedBy($deleteLockedBy)
    {
        $this->deleteLockedBy = $deleteLockedBy;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeleteLockedTime()
    {
        return $this->deleteLockedTime;
    }

    /**
     * @param \DateTime $deleteLockedTime
     * @return $this
     */
    public function setDeleteLockedTime($deleteLockedTime)
    {
        $this->deleteLockedTime = $deleteLockedTime;

        return $this;
    }
}
