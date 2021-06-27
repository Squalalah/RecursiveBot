<?php

$tableau = array();
$groupNum = array();
$MINVALUE = 0;
$MAXVALUE = 25;
$debugMode = 1;

for($i = $MINVALUE; $i < $MAXVALUE; $i++)
{
    $tableau['value'][] = rand(0,1);
    $tableau['check'][] = false;
    if($i % 5 == 0)echo PHP_EOL;
   echo $tableau['value'][$i];
}

//groupnum
/*
 * groupNum[numGroup][numALinterieur];
 *
 */

//array(4, 9, 14, 19, 24)


function checkDuplicate($index, $key) {
    global $tableau, $groupNum, $MAXVALUE, $MINVALUE;
    $numbers = array();
    echo '[checkDuplicate] Je teste la case ' .$index.PHP_EOL;
    if($tableau['check'][$index] == true) return null;
    $tableau['check'][$index] = true;
    if($tableau['value'][$index] == 1)
    {
        echo '[checkDuplicate] La case '. $index. ' est un 1, je l`\'ajoute au tableau '.$key.PHP_EOL;
        $groupNum[$key][] = $index;
        if($index+5 < $MAXVALUE)
        {
            echo '[checkDuplicate] Je teste la case ' .($index+5). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index+5, $key);
            if($numbers !== null) $groupNum[$key][] = $numbers;
        }
        if(!in_array($index, array(4, 9, 14, 19, 24)))
        {
            echo '[checkDuplicate] Je teste la case ' .($index+1). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index+1, $key);
            if($numbers !== null) $groupNum[$key][] = $numbers;
        }
        if(!in_array($index, array(0, 5, 10, 15, 20)))
        {
            echo '[checkDuplicate] Je teste la case ' .($index-1). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index-1, $key);
            if($numbers !== null) $groupNum[$key][] = $numbers;
        }
        if($index-5 > $MINVALUE)
        {
            echo '[checkDuplicate] Je teste la case ' .($index-5). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index-5, $key);
            if($numbers !== null) $groupNum[$key][] = $numbers;
        }
    }
    else return null;
    return $numbers;
}

function findLargerGroup() {
    global $tableau, $groupNum, $MAXVALUE, $MINVALUE;
    echo PHP_EOL;
    for($i = 0; $i < count($tableau['value']); $i++)
    {
        if($tableau['check'][$i] == true) continue;
        echo '[findLargerGroup] Je teste la case '. $i.PHP_EOL;
        $tableau['check'][$i] = true;
        if($tableau['value'][$i] == 1)
        {
            $tableau['check'][$i] = true;
            $key = count($groupNum);
            $groupNum[$key][] = $i;
            echo '[findLargerGroup] La case '. $i. ' est un 1, je l`\'ajoute au tableau '.$key. PHP_EOL;
            if($i+5 < $MAXVALUE)
            {
                if($tableau['check'][$i+5] !== true)
                {
                    echo '[findLargerGroup] Je teste la case ' .($i+5).PHP_EOL;
                    $numbers = checkDuplicate($i+5, $key);
                    if($numbers !== null) $groupNum[$key][] = $numbers;
                }
            }
            if(!in_array($i, array(4, 9, 14, 19, 24)))
            {
                if($tableau['check'][$i+1] !== true)
                {
                echo '[findLargerGroup] Je teste la case ' .($i+1).PHP_EOL;
                $numbers = checkDuplicate($i+1, $key);
                if($numbers !== null) $groupNum[$key][] = $numbers;
                }

            }
            if(!in_array($i, array(0, 5, 10, 15, 20)))
            {
                if($tableau['check'][$i-1] !== true)
                {
                    echo '[findLargerGroup] Je teste la case ' .($i-1).PHP_EOL;
                    $numbers = checkDuplicate($i-1, $key);
                    if($numbers !== null) $groupNum[$key][] = $numbers;
                }
            }
            if($i-5 > $MINVALUE) {
                if ($tableau['check'][$i - 5] !== true)
                {
                    echo '[findLargerGroup] Je teste la case ' . ($i - 5) . PHP_EOL;
                    $numbers = checkDuplicate($i - 5, $key);
                    if ($numbers !== null) $groupNum[$key][] = $numbers;
                }
            }
        }
    }
    $total = 0;
    $index = 0;
    echo 'nb de groupe au total : '.count($groupNum).PHP_EOL;
    for($i = 0; $i < (count($groupNum));$i++)
    {
        $totalTest = 0;
        echo 'GroupNum testé index '.$i.PHP_EOL;
        foreach($groupNum[$i] as $value)
        {
            echo 'GroupNum testé index '.$i.', value = '. $value.PHP_EOL;
            $totalTest++;
        }
        if($totalTest > $total)
        {
            $total = $totalTest;
            $index = $i;
        }
    }
    $string = implode(',',$groupNum[$index]);
   echo 'Le tableau le plus grand est le n°'. ($index) . 'avec '. $total . ' Valeurs'.PHP_EOL;
   echo 'Le tableau comprend '. $string;
}

findLargerGroup();


