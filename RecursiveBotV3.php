<?php

$tableau = array();
$groupNum = array();
$widthTabIncrement = array();
$widthTabDecrement = array();
$MINVALUE = 0;
$debugMode = 0;

function findLargerGroup() : void {
    global $tableau, $groupNum, $debugMode;
    initTableau();
    for($i = 0; $i < count($tableau['value']); $i++)
    {
        if($tableau['check'][$i] == true) continue;
        if($debugMode) echo '[findLargerGroup] Je teste la case '. $i.PHP_EOL;
        checkDuplicate($i);
    }
    showResult($groupNum);
}

function checkDuplicate($index, $key = null, $parentIndex = null) : ?array {
    global $tableau, $groupNum, $MAXVALUE, $MINVALUE, $width, $widthTabIncrement, $widthTabDecrement, $debugMode;
    $numbers = array();
    if($debugMode) {
        if($parentIndex != null) echo '[checkDuplicate] Je teste la case ' .($index). ' via la case '.$parentIndex.PHP_EOL;
        else echo '[checkDuplicate] Je teste la case ' .$index.PHP_EOL;
    }
    if($tableau['check'][$index] == true) return null;
    $tableau['check'][$index] = true;
    if($tableau['value'][$index] == 1)
    {
        if($key === null) $key = count($groupNum);
        if($debugMode) echo '[checkDuplicate] La case '. $index. ' est un 1, je l`\'ajoute au tableau '.$key.PHP_EOL;
        $groupNum[$key][] = $index;
        if($index+$width < $MAXVALUE)
        {
            $numbers = checkDuplicate($index+$width, $key, $index);
        }
        if(!in_array($index, $widthTabIncrement))
        {
            $numbers = checkDuplicate($index+1, $key, $index);
        }
        if(!in_array($index, $widthTabDecrement))
        {
            $numbers = checkDuplicate($index-1, $key, $index);
        }
        if($index-$width > $MINVALUE)
        {
            $numbers = checkDuplicate($index-$width, $key, $index);
        }
        if($numbers !== null) $groupNum[$key][] = $numbers;
    }
    else return null;
    return $numbers;
}

function initTableau() : void {
    global $tableau, $width, $length, $MINVALUE, $MAXVALUE, $widthTabIncrement, $widthTabDecrement, $debugMode;
    for($i = $width-1; $i < $width*$length; $i+=$width)
    {
        $widthTabIncrement[] = $i;
        if($debugMode) echo $i.PHP_EOL;
    }
    for($i = 0; $i <= ($width*$length)-$width; $i +=$width) {
        $widthTabDecrement[] = $i;
    }
    for($i = $MINVALUE; $i < $MAXVALUE; $i++)
    {
        $tableau['value'][] = rand(0,1);
        $tableau['check'][] = false;
        if($i % $width == 0) echo PHP_EOL; // retour à la ligne pour faire un carré/rectangle compréhensible vu la nature de l'algorithme.
        echo $tableau['value'][$i];
    }
    echo PHP_EOL;
}

function showResult($groupNum) : void {
    global $debugMode;
    $groupResult = array();
    $total = 0;
    $index = array();
    if($debugMode) echo 'nb de groupe au total : '.count($groupNum).PHP_EOL;
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
                $index[] = $i;
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


