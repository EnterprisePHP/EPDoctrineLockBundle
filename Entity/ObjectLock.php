<?php

namespace EP\DoctrineLockBundle\Entity;

/**
 * ObjectLock
 */
class ObjectLock
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var  string
     */
    protected $objectClass;

    /**
     * @var bool
     */
    protected $fullLocked = false;

    /**
     * @var bool
     */
    protected $insertLocked = false;

    /**
     * @var bool
     */
    protected $updateLocked = false;

    /**
     * @var bool
     */
    protected $deleteLocked = false;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getObjectClass()
    {
        return $this->objectClass;
    }

    /**
     * @param  string $objectClass
     * @return $this
     */
    public function setObjectClass($objectClass)
    {
        $this->objectClass = $objectClass;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isFullLocked()
    {
        return $this->fullLocked;
    }

    /**
     * @param boolean $fullLocked
     */
    public function setFullLocked($fullLocked)
    {
        $this->fullLocked = $fullLocked;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isInsertLocked()
    {
        return $this->insertLocked;
    }

    /**
     * @param boolean $insertLocked
     * @return $this
     */
    public function setInsertLocked($insertLocked)
    {
        $this->insertLocked = $insertLocked;

        return $this;
    }

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
