<?php
class First
{

    public function getClassname()
    {
        echo get_called_class() . "\n";
    }

    public function getLetter()
    {
        echo "A\n";
    }
}
