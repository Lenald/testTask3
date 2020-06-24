<?php

class Sorter
{
    public function run(string $input) {

        $array = explode(" ", $input);

        foreach ($array as $key => $value) {
            $value = (int) $value;
            if ($array[$key] != $value) {
                unset ($array[$key]);
            } else {
                //на всякий случай проверим на то, что изначально оно было в том же виде
                $value2 = strval($value);
                if ($array[$key] === $value2) {
                    $array[$key] = $value;
                } else {
                    unset($array[$key]);
                }
            }
        }

        $array = array_unique($array, SORT_NUMERIC);
        sort($array, SORT_NUMERIC);

        echo implode(" ", $array) . "\n";

    }
}