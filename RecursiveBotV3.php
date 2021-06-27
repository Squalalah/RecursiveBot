<?php

$tableau = array();
$groupNum = array();
$widthTabIncrement = array();
$widthTabDecrement = array();
$MINVALUE = 0;
$debugMode = 1;

//groupnum
/*
 * groupNum[numGroup][numALinterieur];
 *
 */

//array(4, 9, 14, 19, 24)


function checkDuplicate($index, $key = null) {
    global $tableau, $groupNum, $MAXVALUE, $MINVALUE, $width, $widthTabIncrement, $widthTabDecrement, $debugMode;
    $numbers = array();
    if($debugMode) echo '[checkDuplicate] Je teste la case ' .$index.PHP_EOL;
    if($tableau['check'][$index] == true) return null;
    $tableau['check'][$index] = true;
    if($tableau['value'][$index] == 1)
    {
        if($key === null)
        {
            $key = count($groupNum);
        }
        if($debugMode) echo '[checkDuplicate] La case '. $index. ' est un 1, je l`\'ajoute au tableau '.$key.PHP_EOL;
        $groupNum[$key][] = $index;
        if($index+$width < $MAXVALUE)
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index+$width). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index+$width, $key);
        }
        if(!in_array($index, $widthTabIncrement))
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index+1). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index+1, $key);
        }
        if(!in_array($index, $widthTabDecrement))
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index-1). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index-1, $key);
        }
        if($index-$width > $MINVALUE)
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index-$width). 'via la case '.$index.PHP_EOL;
            $numbers = checkDuplicate($index-$width, $key);
        }
        if($numbers !== null) $groupNum[$key][] = $numbers;
    }
    else return null;
    return $numbers;
}

function initTableau() {
    global $tableau, $width, $length, $MINVALUE, $MAXVALUE, $widthTabIncrement, $widthTabDecrement;
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
}

function findLargerGroup() {
    global $tableau, $groupNum, $debugMode;
    $total = 0;
    $index = array();
    initTableau();
    echo PHP_EOL;
    for($i = 0; $i < count($tableau['value']); $i++)
    {
        if($tableau['check'][$i] == true) continue;
        if($debugMode) echo '[findLargerGroup] Je teste la case '. $i.PHP_EOL;
        checkDuplicate($i);
    }
    if($debugMode) echo 'nb de groupe au total : '.count($groupNum).PHP_EOL;
    $groupResult = array();
    for($i = 0; $i < count($groupNum);$i++)
    {
        if($debugMode) echo 'TEST n°: '. $i.PHP_EOL;
        switch($total <=> count($groupNum[$i]))
        {
            case -1: {
                unset($groupResult);
                unset($index);
                $index[] = $i;
                $groupResult[$i][] = $groupNum[$i];
                $total = count($groupNum[$i]);
                break;
            }
            case 0: {
                $groupResult[$i][] = $groupNum[$i];
                break;
            }
        }
    }
    $str = 'Résultats : '.PHP_EOL;
    if(count($groupResult) >= 1)
    {
        for($a = 0; $a < count($groupResult); $a++) {
            $str .= '[Tableau n°'.($index[$a]+1).' avec '.$total. ' valeurs]'.PHP_EOL;
        }
        echo $str;
    }
    else echo 'Il n\'y a aucun 1, donc aucun tableau';
}

$file = fopen('php://stdin', 'r');
do {
    echo 'Veuillez écrire une largeur'. PHP_EOL;
    $width = trim(fgets($file));
    echo 'Veuillez écrire une longueur'. PHP_EOL;
    $length = trim(fgets($file));
    if(!preg_match('/[0-9]/', $width) || !preg_match('/[0-9]/', $length)) {
        echo '[ERREUR] Merci d\'entrer une valeur correcte'.PHP_EOL;
        continue;
    }
    break;
}while(1 != 2);
$MAXVALUE = $width*$length;
$time_start = microtime(true);
findLargerGroup();
$time_end = microtime(true);
if($debugMode == 1) echo 'Temps d\'execution : '. ($time_end-$time_start);


