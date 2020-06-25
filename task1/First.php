<?php
class First
{
    private $letter = "A";

    public function getClassname()
    {
        echo get_called_class() . "\n";
    }

    public function getLetter()
    {
        echo $this->letter ."\n";
    }
}
