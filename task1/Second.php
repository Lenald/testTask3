<?php
class Second extends First
{
    private $letter = "B";

    public function getLetter()
    {
        echo $this->letter ."\n";
    }

}
