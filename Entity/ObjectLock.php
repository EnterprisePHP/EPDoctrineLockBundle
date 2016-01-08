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
    public function isInsertLocked()
    {
        return $this->insertLocked;
    }

    /**
     * @param boolean $insertLocked
     */
    public function setInsertLocked($insertLocked)
    {
        $this->insertLocked = $insertLocked;
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
     */
    public function setUpdateLocked($updateLocked)
    {
        $this->updateLocked = $updateLocked;
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
     */
    public function setDeleteLocked($deleteLocked)
    {
        $this->deleteLocked = $deleteLocked;
    }
}
