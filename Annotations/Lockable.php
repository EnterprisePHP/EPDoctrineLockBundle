<?php

namespace EP\DoctrineLockBundle\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Lockable extends Annotation
{
}