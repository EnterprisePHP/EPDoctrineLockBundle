# DoctrineLockBundle
- Lock objects against insert, delete, update events
- Lock entities against delete, update events

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9e66e05d-ff79-4a8b-9cb0-dd547f95c162/small.png)](https://insight.sensiolabs.com/projects/9e66e05d-ff79-4a8b-9cb0-dd547f95c162)
[![knpbundles.com](http://knpbundles.com/EnterprisePHP/EPDisplayBundle/badge-short)](http://knpbundles.com/EnterprisePHP/EPDisplayBundle)

### Related Links;###
  - https://github.com/ojs/ojs/issues/990
  - https://github.com/ojs/ojs/blob/master/src/Ojs/CoreBundle/Service/Twig/DisplayExtension.php
<hr>

- Development steps can be followed from https://github.com/behramcelen/symfony-bundle-develop
- A basic test and logic controller and view can be found in https://github.com/behramcelen/symfony-bundle-develop/blob/master/src/AppBundle/Controller/DisplayController.php#L16
- https://github.com/behramcelen/symfony-bundle-develop/blob/master/src/AppBundle/Resources/views/Display/display.html.twig#L7


Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, go to your project directory and execute the
following command to download the latest version of this bundle:

```bash
$ composer require enterprisephp/display-bundle "dev-master"
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

            new EP\DisplayBundle\EPDisplayBundle(),
        );

        // ...
    }

    // ...
}
```
DisplayTrait
-------------
use DisplayTrait on which you want to display objects/entities (!important):
```php

namespace AppBundle\Entity;

use EP\DoctrineLockBundle\Traits\LockableTrait;

class MyEntity
{
    use DisplayTrait;
}
```

Configuration
=============

Add below configs to `config.yml` file:
```
ep_display:
    global:
        image_render: true # (optinal) defaults to true
        file_render: true # (optinal) defaults to true
        template: EPDisplayBundle::display.html.twig # (optinal) defaults to EPDisplayBundle:display.html.twig template
        exclude_vars: # (optinal) defaults to empty array
            - excludeField
            - hiddenField
            - password
        array_collection_render: true # (optinal) defaults to true
        collection_item_count: 5 # (optinal) defaults to 10
```
