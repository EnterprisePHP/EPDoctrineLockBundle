<?php

namespace EP\DoctrineLockBundle\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Lockable
{
    /**
     * @var boolean
     */
    public $preUpdateCheckEnabled = true;

    /**
     * @var boolean
     */
    private $preDeleteCheckEnabled = true;

    public function __construct($options)
    {
        foreach ($options as $key => $value) {
            if (!property_exists($this, $key)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
            }
            $this->$key = $value;
        }
    }

    /**
     * @return boolean
     */
    public function isPreUpdateCheckEnabled()
    {
        return $this->preUpdateCheckEnabled;
    }

    /**
     * @return boolean
     */
    public function isPreDeleteCheckEnabled()
    {
        return $this->preDeleteCheckEnabled;
    }
}