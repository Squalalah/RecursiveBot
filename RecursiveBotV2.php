<?php

$tableau = array();
$groupNum = array();
$width = 5;
$widthTabIncrement = array();
$widthTabDecrement = array();
$MINVALUE = 0;
$length = 5;
$MAXVALUE = $width*$length;
$debugMode = 1;
ini_set('memory_limit', '-1');

//groupnum
/*
 * groupNum[numGroup][numALinterieur];
 *
 */

//array(4, 9, 14, 19, 24)


function checkDuplicate($index, $key) {
    global $tableau, $groupNum, $MAXVALUE, $MINVALUE, $width, $widthTabIncrement, $widthTabDecrement, $debugMode;
    $numbers = array();
    if($debugMode) echo '[checkDuplicate] Je teste la case ' .$index.PHP_EOL;
    if($tableau['check'][$index] == true) return null;
    $tableau['check'][$index] = true;
    if($tableau['value'][$index] == 1)
    {
        if($debugMode) echo '[checkDuplicate] La case '. $index. ' est un 1, je l`\'ajoute au tableau '.$key.PHP_EOL;
        $groupNum[$key][] = $index;
        if($index+$width < $MAXVALUE)
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index+$width). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index+$width, $key);
            if($numbers !== null) $groupNum[$key][] = $numbers;
        }
        if(!in_array($index, $widthTabIncrement))
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index+1). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index+1, $key);
            if($numbers !== null) $groupNum[$key][] = $numbers;
        }
        if(!in_array($index, $widthTabDecrement))
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index-1). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index-1, $key);
            if($numbers !== null) $groupNum[$key][] = $numbers;
        }
        if($index-$width > $MINVALUE)
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index-$width). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index-$width, $key);
            if($numbers !== null) $groupNum[$key][] = $numbers;
        }
    }
    else return null;
    return $numbers;
}

function findLargerGroup() {
    //$min = 0 / 4;
    //$max = 20 / 24;
    // +5 / -5
    global $tableau, $groupNum, $MAXVALUE, $MINVALUE, $width, $length, $widthTabIncrement, $widthTabDecrement, $debugMode;
    for($i = $width-1; $i < $width*$length; $i+=$width)
    {
        $widthTabIncrement[] = $i;
        echo $i.PHP_EOL;
    }
    for($i = 0; $i <= ($width*$length)-$width; $i +=$width) {
        $widthTabDecrement[] = $i;
    }
    for($i = $MINVALUE; $i < $MAXVALUE; $i++)
    {
        $tableau['value'][] = rand(0,1);
        $tableau['check'][] = false;
        if($i % $width == 0) echo PHP_EOL;
        echo $tableau['value'][$i];
    }
    echo PHP_EOL;
    for($i = 0; $i < count($tableau['value']); $i++)
    {
        if($tableau['check'][$i] == true) continue;
        if($debugMode) echo '[findLargerGroup] Je teste la case '. $i.PHP_EOL;
        $tableau['check'][$i] = true;
        if($tableau['value'][$i] == 1)
        {
            $tableau['check'][$i] = true;
            $key = count($groupNum);
            $groupNum[$key][] = $i;
            if($debugMode) echo '[findLargerGroup] La case '. $i. ' est un 1, je l`\'ajoute au tableau '.$key. PHP_EOL;
            if($i+$width < $MAXVALUE)
            {
                if($tableau['check'][$i+$width] !== true)
                {
                    if($debugMode) echo '[findLargerGroup] Je teste la case ' .($i+$width).PHP_EOL;
                    $numbers = checkDuplicate($i+$width, $key);
                    if($numbers !== null) $groupNum[$key][] = $numbers;
                }
            }
            if(!in_array($i, $widthTabIncrement))
            {
                if($tableau['check'][$i+1] !== true)
                {
                if($debugMode) echo '[findLargerGroup] Je teste la case ' .($i+1).PHP_EOL;
                $numbers = checkDuplicate($i+1, $key);
                if($numbers !== null) $groupNum[$key][] = $numbers;
                }

            }
            if(!in_array($i, $widthTabDecrement))
            {
                if($tableau['check'][$i-1] !== true)
                {
                    if($debugMode) echo '[findLargerGroup] Je teste la case ' .($i-1).PHP_EOL;
                    $numbers = checkDuplicate($i-1, $key);
                    if($numbers !== null) $groupNum[$key][] = $numbers;
                }
            }
            if($i-$width > $MINVALUE) {
                if ($tableau['check'][$i - $width] !== true)
                {
                    if($debugMode) echo '[findLargerGroup] Je teste la case ' . ($i - $width) . PHP_EOL;
                    $numbers = checkDuplicate($i - $width, $key);
                    if ($numbers !== null) $groupNum[$key][] = $numbers;
                }
            }
        }
    }
    $total = 0;
    $index = 0;
    if($debugMode) echo 'nb de groupe au total : '.count($groupNum).PHP_EOL;
    for($i = 0; $i < (count($groupNum));$i++)
    {
        $totalTest = 0;
        if($debugMode) echo 'GroupNum test?? index '.$i.PHP_EOL;
        foreach($groupNum[$i] as $value)
        {
            if($debugMode) echo 'GroupNum test?? index '.$i.', value = '. $value.PHP_EOL;
            $totalTest++;
        }
        if($totalTest > $total)
        {
            $total = $totalTest;
            $index = $i;
        }
    }
    $string = implode(',',$groupNum[$index]);
    echo 'Le tableau le plus grand est le n??'. ($index+1) . 'avec '. $total . ' Valeurs'.PHP_EOL;
    echo 'Le tableau comprend '. $string;
}

$file = fopen('php://stdin', 'r');
echo 'Veuillez ??crire une largeur'. PHP_EOL;
$width = (int)trim(fgets($file));
echo 'Veuillez ??crire une longueur'. PHP_EOL;
$length = (int)trim(fgets($file));
$MAXVALUE = $width*$length;
findLargerGroup();


