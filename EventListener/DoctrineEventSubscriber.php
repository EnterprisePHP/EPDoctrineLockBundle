<?php

namespace EP\DoctrineLockBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use EP\DoctrineLockBundle\Entity\ObjectLock;
use EP\DoctrineLockBundle\Exception\LockedObjectException;
use EP\DoctrineLockBundle\Params\ObjectLockParams;
use EP\DoctrineLockBundle\Service\ObjectLocker;
use EP\DoctrineLockBundle\Service\ObjectLockerInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class DoctrineEventSubscriber implements EventSubscriber
{
    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    /**
     * DoctrineEventListener constructor.
     * @param PropertyAccessorInterface $accessor
     */
    public function __construct( PropertyAccessorInterface $accessor)
    {
        $this->accessor = $accessor;
    }

    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preRemove',
            'preUpdate',
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     * @return bool
     * @throws LockedObjectException
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof ObjectLock){
            return $args;
        }
        $em = $args->getEntityManager();
        $objectLocker = new ObjectLocker($em, $this->accessor);

        $isFullLocked = $objectLocker->isLocked($entity);
        if($isFullLocked){
            throw new LockedObjectException('You tried insert row an fully locked object');
        }
        $isInsertLocked = $objectLocker->isLocked($entity, ObjectLockParams::INSERT_LOCK);
        if($isInsertLocked){
            throw new LockedObjectException('You tried insert row an insert locked object');
        }
        return true;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return bool
     * @throws LockedObjectException
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof ObjectLock){
            return true;
        }

        $em = $args->getEntityManager();
        $objectLocker = new ObjectLocker($em, $this->accessor);

        $isFullLocked = $objectLocker->isLocked($entity);
        if($isFullLocked){
            throw new LockedObjectException('You tried delete entity an fully locked object');
        }
        $isInsertLocked = $objectLocker->isLocked($entity, ObjectLockParams::DELETE_LOCK);
        if($isInsertLocked){
            throw new LockedObjectException('You tried delete entity an delete locked object');
        }
        return true;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return bool
     * @throws LockedObjectException
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof ObjectLock){
            return true;
        }
        $em = $args->getEntityManager();
        $objectLocker = new ObjectLocker($em, $this->accessor);

        $isFullLocked = $objectLocker->isLocked($entity);
        if($isFullLocked){
            throw new LockedObjectException('You tried update row an fully locked object');
        }
        $isInsertLocked = $objectLocker->isLocked($entity, ObjectLockParams::UPDATE_LOCK);
        if($isInsertLocked){
            throw new LockedObjectException('You tried update row an update locked object');
        }
        return true;
    }
}