<?php
namespace SafetyExit\Exceptions;

use Exception;

class InvalidSetting extends Exception
{
    public function __construct($message = 'Invalid setting key', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
