<?php

namespace EP\DoctrineLockBundle\Exception;

class LockedObjectException extends \Exception
{
    public function __construct($message, $code = 500, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}