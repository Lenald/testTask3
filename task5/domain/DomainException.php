<?php

namespace Domain;

class DomainException extends \Exception
{
    public function toArray()
    {
        return array(
            'message'  => $this->getMessage(),
            'previous' => $this->getPrevious(),
            'code'     => $this->getCode(),
            'file'     => $this->getFile(),
            'line'     => $this->getLine(),
            'trace'    => $this->getTrace()
        );
    }
}
