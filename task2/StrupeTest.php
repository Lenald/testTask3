<?php
class StrupeTest
{
    private $words = ['red', 'blue', 'green', 'yellow', 'lime', 'magenta', 'black', 'gold', 'gray', 'tomato'];

    private function chooseColor($word)
    {
        //создаём массив цветов, которые не совпадают со словом
        $freeColors = array_values(array_diff($this->words, [$word]));
        $index = random_int(0, count($freeColors)-1);

        return $freeColors[$index];
    }

    private function chooseWord()
    {
        $index = random_int(0, count($this->words)-1);

        return $this->words[$index];
    }

    private function getLine() {
        $row = "";

        for ($i = 0; $i < WORDS_PER_ROW; $i++) {
            $word = $this->chooseWord();
            $color = $this->chooseColor($word);
            $row .= "<font color=\"$color\">$word</font> ";
        }

        return trim($row);
    }

    public function run()
    {
        for ($i = 0; $i < ROWS; $i++) {
            echo $this->getLine() . "<br>";
        }

    }
}