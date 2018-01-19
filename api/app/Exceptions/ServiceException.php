<?php

namespace App\Exceptions;

use Throwable;

class ServiceException extends \Exception
{
    public $data;

    public function __construct(string $message, $data)
    {
        parent::__construct($message);
        $this->data = $data;
    }
}
