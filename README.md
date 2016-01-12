# DoctrineLockBundle
- Lock objects against insert, delete, update events
- Lock entities against delete, update events

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9e66e05d-ff79-4a8b-9cb0-dd547f95c162/small.png)](https://insight.sensiolabs.com/projects/9e66e05d-ff79-4a8b-9cb0-dd547f95c162)
[![knpbundles.com](http://knpbundles.com/EnterprisePHP/EPDoctrineLockBundle/badge-short)](http://knpbundles.com/EnterprisePHP/EPDoctrineLockBundle)

### Related Links;###
  - https://github.com/doctrine/doctrine2/blob/master/docs/en/reference/transactions-and-concurrency.rst#locking-support
  - http://dev.mysql.com/doc/refman/5.7/en/lock-tables.html
  - https://www.wikiwand.com/en/Lock_(database)
  - http://stackoverflow.com/questions/129329/optimistic-vs-pessimistic-locking
<hr>

- Developing steps can be follow from https://github.com/behramcelen/symfony-bundle-develop
- An basic testing and logic command can be found in https://github.com/behramcelen/symfony-bundle-develop/blob/master/src/AppBundle/Command/LockBundleTestCommand.php#L41 


Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest version of this bundle:

```bash
$ composer require enterprisephp/doctrine-lock-bundle "dev-master"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new EP\DoctrineLockBundle\EPDoctrineLockBundle(),
        );

        // ...
    }

    // ...
}
```

Usage
============

Doctrine Object Lock
---------------------------
```php
use EP\DoctrineLockBundle\Params\ObjectLockParams;
// ...
$objectLocker = $container->get('ep.doctrine.object.locker');
//lock fully
$objectLocker->lock(new DummyEntity());
//lock delete process
$objectLocker->lock(new DummyEntity(), ObjectLockParams::DELETE_LOCK);
//lock insert process
$objectLocker->lock(new DummyEntity(), ObjectLockParams::INSERT_LOCK);
//lock update process
$objectLocker->lock(new DummyEntity(), ObjectLockParams::UPDATE_LOCK);
```
Doctrine Object UnLock
---------------------------
```php
use EP\DoctrineLockBundle\Params\ObjectLockParams;
// ...
$objectLocker = $container->get('ep.doctrine.object.locker');
//unlock full lock
$objectLocker->unlock(new DummyEntity());
//unlock delete process
$objectLocker->unlock(new DummyEntity(), ObjectLockParams::DELETE_LOCK);
//unlock insert process
$objectLocker->unlock(new DummyEntity(), ObjectLockParams::INSERT_LOCK);
//unlock update process
$objectLocker->unlock(new DummyEntity(), ObjectLockParams::UPDATE_LOCK);
```
Doctrine Object Switch Lock
---------------------------
```php
use EP\DoctrineLockBundle\Params\ObjectLockParams;
// ...
$objectLocker = $container->get('ep.doctrine.object.locker');
//switch full lock
$objectLocker->switchLock(new DummyEntity());
//switch delete process
$objectLocker->switchLock(new DummyEntity(), ObjectLockParams::DELETE_LOCK);
//switch insert process
$objectLocker->switchLock(new DummyEntity(), ObjectLockParams::INSERT_LOCK);
//unswitchlock update process
$objectLocker->switchLock(new DummyEntity(), ObjectLockParams::UPDATE_LOCK);
```
Doctrine Object Is Locked
---------------------------
```php
use EP\DoctrineLockBundle\Params\ObjectLockParams;
// ...
$objectLocker = $container->get('ep.doctrine.object.locker');
//is full locked
$objectLocker->isLocked(new DummyEntity());
//is delete locked
$objectLocker->isLocked(new DummyEntity(), ObjectLockParams::DELETE_LOCK);
//is insert locked
$objectLocker->isLocked(new DummyEntity(), ObjectLockParams::INSERT_LOCK);
//is update locked
$objectLocker->isLocked(new DummyEntity(), ObjectLockParams::UPDATE_LOCK);
```
### Example Use ###
```php
$objectLocker = $container->get('ep.doctrine.object.locker');
//lock object
$objectLocker->lock(new DummyEntity());
$em->persist(new DummyEntity()); // this will throw LockedObjectException
```

Doctrine Entity Lock
---------------------------
#### Add Lockable annotation and lockable trait ####
```php
namespace AppBundle\Entity;

use EP\DoctrineLockBundle\Traits\LockableTrait;
use EP\DoctrineLockBundle\Annotations\Lockable;

/**
 * @Lockable
 */
class DummyEntity
{
    use LockableTrait;
    // ...
```
#### Example Use ####
```php
//create new dummy entity
$dummyEntity = new DummyEntity();
$dummyEntity
    ->setTitle('Dummy Entity Title')
    ->setDescription('Dummy Entity Description')
    ->setUpdateLocked(true) //lock entity for update process
    ->setDeleteLocked(true) //lock entity for delete process
;
$em->persist($dummyEntity);
$em->flush();

$dummyEntity->setTitle('Update Dummy Entity Title');
$em->persist($dummyEntity);
$em->flush(); // this will throw LockedEntityException because entity have update lock

$em->remove($dummyEntity); // this will throw LockedEntityException because entity have delete lock
```
##### Unlock Entity Lock #####
```php
//unlock update lock
$dummyEntity->setUpdateLocked(false);
//unlock delete lock
$dummyEntity->setDeleteLocked(false);
```
