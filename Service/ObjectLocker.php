<?php

namespace EP\DoctrineLockBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\MappingException;
use EP\DoctrineLockBundle\Params\ObjectLockParams;
use EP\DoctrineLockBundle\Entity\ObjectLock;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class ObjectLocker
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    /**
     * ObjectLocker constructor.
     * @param EntityManager $em
     * @param PropertyAccessorInterface $accessor
     */
    public function __construct(EntityManager $em, PropertyAccessorInterface $accessor)
    {
        $this->em = $em;
        $this->accessor = $accessor;
    }

    /**
     * @param $object
     * @param string $lockType
     * @return bool
     * @throws \Exception
     */
    public function lock($object, $lockType = ObjectLockParams::FULL_LOCK)
    {
        $objectClassName = $this->getObjectClassName($object);
        $objectDetail = $this->getObjectDetail($objectClassName);
        if(!$objectDetail){
            $objectDetail = $this->setupObjectDetail($objectClassName);
        }
        $this->accessor->setValue($objectDetail, $lockType, true);
        $this->em->persist($objectDetail);
        $this->em->flush();

        return true;
    }

    /**
     * @param $object object
     * @param string $lockType
     * @return bool
     * @throws \Exception
     */
    public function unlock($object, $lockType = ObjectLockParams::FULL_LOCK)
    {
        $objectClassName = $this->getObjectClassName($object);
        $objectDetail = $this->getObjectDetail($objectClassName);
        if(!$objectDetail){
            $objectDetail = $this->setupObjectDetail($objectClassName);
        }
        $this->accessor->setValue($objectDetail, $lockType, false);
        $this->em->persist($objectDetail);
        $this->em->flush();

        return true;
    }

    /**
     * @param $object
     * @param string $lockType
     * @return bool
     * @throws \Exception
     */
    public function switchLock($object, $lockType = ObjectLockParams::FULL_LOCK)
    {
        $objectClassName = $this->getObjectClassName($object);
        $objectDetail = $this->getObjectDetail($objectClassName);
        if(!$objectDetail){
            $objectDetail = $this->setupObjectDetail($objectClassName);
        }
        if($this->accessor->getValue($objectDetail, $lockType) === true){
            $this->accessor->setValue($objectDetail, $lockType, false);
        }else{
            $this->accessor->setValue($objectDetail, $lockType, true);
        }
        $this->em->persist($objectDetail);
        $this->em->flush();

        return true;
    }

    /**
     * @param $object
     * @return string
     * @throws MappingException
     * @throws \Exception
     */
    private function getObjectClassName($object)
    {
        try {
            $objectName = $this->em->getMetadataFactory()->getMetadataFor(get_class($object))->getName();
        } catch (MappingException $e) {
            throw new \Exception('Given object ' . get_class($object) . ' is not a Doctrine Entity. ');
        }

        return $objectName;
    }

    /**
     * @param $objectClassName
     * @return ObjectLock|null
     */
    private function getObjectDetail($objectClassName)
    {
        return $this->em->getRepository('EPDoctrineLockBundle:ObjectLock')->findOneBy([
           'objectClass' => $objectClassName
        ]);
    }

    /**
     * @param $objectClassName string
     * @return ObjectLock
     */
    private function setupObjectDetail($objectClassName)
    {
        $objectLock = new ObjectLock();
        $objectLock
            ->setObjectClass($objectClassName)
            ->setFullLocked(false)
            ->setInsertLocked(false)
            ->setUpdateLocked(false)
            ->setDeleteLocked(false)
            ;
        $this->em->persist($objectLock);
        $this->em->flush();
        return $objectLock;
    }
}
