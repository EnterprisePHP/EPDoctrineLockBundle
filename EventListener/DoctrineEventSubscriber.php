<?php

namespace EP\DoctrineLockBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use EP\DoctrineLockBundle\Entity\ObjectLock;
use EP\DoctrineLockBundle\Exception\LockedEntityException;
use EP\DoctrineLockBundle\Exception\LockedObjectException;
use EP\DoctrineLockBundle\Params\ObjectLockParams;
use EP\DoctrineLockBundle\Service\ObjectLocker;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Annotations\AnnotationReader;

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
            Events::prePersist,
            Events::preRemove,
            Events::preUpdate,
            Events::loadClassMetadata,
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     * @throws LockedObjectException
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof ObjectLock){
            return;
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
        return;
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws LockedEntityException
     * @throws LockedObjectException
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof ObjectLock){
            return;
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
        if(!$this->isLockableEntity($entity)){
            return;
        }
        if($entity->isDeleteLocked()){
            throw new LockedEntityException('You tried delete row that delete locked entity');
        }
        return;
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws LockedEntityException
     * @throws LockedObjectException
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof ObjectLock){
            return;
        }
        $em = $args->getEntityManager();
        $objectLocker = new ObjectLocker($em, $this->accessor);

        $isFullLocked = $objectLocker->isLocked($entity);
        if($isFullLocked){
            throw new LockedObjectException('You tried update row an fully locked object');
        }
        $isUpdateLocked = $objectLocker->isLocked($entity, ObjectLockParams::UPDATE_LOCK);
        if($isUpdateLocked){
            throw new LockedObjectException('You tried update row an update locked object');
        }
        if(!$this->isLockableEntity($entity)){
            return;
        }
        if($entity->isUpdateLocked()){
            throw new LockedEntityException('You tried update row an update locked entity');
        }
        return;
    }

    /**
     * Add mapping to lockable entities
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     * @return void
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $reader = new AnnotationReader();
        /** @var ClassMetadata $classMetadata */
        $classMetadata = $eventArgs->getClassMetadata();
        /** @var \ReflectionClass $reflClass */
        $reflClass = $classMetadata->reflClass;

        if (!$reflClass || $reflClass->isAbstract()) {
            return;
        }
        $lockableAnnotation = $reader->getClassAnnotation($reflClass, 'EP\\DoctrineLockBundle\\Annotations\\Lockable');
        if($lockableAnnotation !== null){
            $this->mapLockable($classMetadata);
        }
    }

    /**
     * @param $entity
     * @return bool
     */
    private function isLockableEntity($entity)
    {
        $reader = new AnnotationReader();
        $reflClass = new \ReflectionClass($entity);
        $lockableAnnotation = $reader->getClassAnnotation($reflClass, 'EP\\DoctrineLockBundle\\Annotations\\Lockable');
        if($lockableAnnotation == null){
            return false;
        }
        if(!method_exists($entity, 'isUpdateLocked') || !method_exists($entity, 'isDeleteLocked')){
            throw new \LogicException('Please use Lockable trait on '. $reflClass->getName());
        }
        return true;
    }

    /**
     * map lockable fields if not mapped
     *
     * @param ClassMetadata $classMetadata
     */
    private function mapLockable(ClassMetadata $classMetadata)
    {
        // Map update lock field
        if (!$classMetadata->hasField('updateLocked')) {
            $classMetadata->mapField(
                array(
                    'fieldName' => 'updateLocked',
                    'type' => 'boolean',
                )
            );
        }

        // Map delete lock field
        if (!$classMetadata->hasField('deleteLocked')) {
            $classMetadata->mapField(
                array(
                    'fieldName' => 'deleteLocked',
                    'type' => 'boolean',
                )
            );
        }
    }
}