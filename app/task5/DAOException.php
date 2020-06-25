<?php
namespace DAO;

class DAOException extends \Exception
{
    
    public function toArray() {
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
