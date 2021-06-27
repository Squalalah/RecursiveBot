<?php

$tableau = array();
$groupNum = array();
$width = 5;
$widthTabIncrement = array();
$widthTabDecrement = array();
$MINVALUE = 0;
$length = 5;
$debugMode = 1;
ini_set('memory_limit', '-1');

//groupnum
/*
 * groupNum[numGroup][numALinterieur];
 *
 */

//array(4, 9, 14, 19, 24)

?>

<form method="POST" action="#">
    <label for="width">Largeur : </label>
    <input type="number" name="width" id="width" min="1"><br>
    <label for="length">Longueur : </label>
    <input type="number" name="length" id="length" min="1"><br>
    <label for="debug">DebugMode : </label>
    <input type="number" name="debug" id="debug" min="0" max="1"><br>
    <input type="submit" value="Envoyer">
</form>

<?php

if(isset($_POST['width']) && isset($_POST['length']) && isset($_POST['debug'])) {
    if(preg_match('/[0-9]/', $_POST['width']) && preg_match('/[0-9]/', $_POST['length']))
    {
        if($_POST['debug'] == 1) $debugMode = 1;
        else $debugMode = 0;
        $width = intval($_POST['width']);
        $length = intval($_POST['length']);
        $MAXVALUE = $width*$length;
        findLargerGroup();
    }
    else echo '[ERREUR] Merci d\'entrer des vrais valeurs !<br>';
}

function checkDuplicate($index, $key = null) {
    global $tableau, $groupNum, $MAXVALUE, $MINVALUE, $width, $widthTabIncrement, $widthTabDecrement, $debugMode;
    $numbers = array();
    if($debugMode) echo '[checkDuplicate] Je teste la case ' .$index.'<br>';
    if($tableau['check'][$index] == true) return null;
    $tableau['check'][$index] = true;
    if($tableau['value'][$index] == 1)
    {
        if($key === null)
        {
            $key = count($groupNum);
        }
        if($debugMode) echo '[checkDuplicate] La case '. $index. ' est un 1, je l`\'ajoute au tableau '.$key.'<br>';
        $groupNum[$key][] = $index;
        if($index+$width < $MAXVALUE)
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index+$width). 'via la case '.$index.'<br>';
            $numbers = checkDuplicate($index+$width, $key);
        }
        if(!in_array($index, $widthTabIncrement))
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index+1). 'via la case '.$index.'<br>';
            $numbers = checkDuplicate($index+1, $key);
        }
        if(!in_array($index, $widthTabDecrement))
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index-1). 'via la case '.$index.'<br>';
            $numbers = checkDuplicate($index-1, $key);
        }
        if($index-$width > $MINVALUE)
        {
            if($debugMode) echo '[checkDuplicate] Je teste la case ' .($index-$width). 'via la case '.$index.'<br>';
            $numbers = checkDuplicate($index-$width, $key);
        }
        if($numbers !== null) $groupNum[$key][] = $numbers;
    }
    else return null;
    return $numbers;
}

function initTableau() {
    global $tableau, $width, $length, $MINVALUE, $MAXVALUE, $widthTabIncrement, $debugMode, $widthTabDecrement;
    for($i = $width-1; $i < $width*$length; $i+=$width)
    {
        $widthTabIncrement[] = $i;
        if($debugMode) echo $i.'<br>';
    }
    for($i = 0; $i <= ($width*$length)-$width; $i +=$width) {
        $widthTabDecrement[] = $i;
        if($debugMode) echo $i.'<br>';
    }
    for($i = $MINVALUE; $i < $MAXVALUE; $i++)
    {
        $tableau['value'][] = rand(0,1);
        $tableau['check'][] = false;
        if($i % $width == 0) echo '<br>';
        echo $tableau['value'][$i];
    }
}

function findLargerGroup() {
    global $tableau, $groupNum, $debugMode;
    $total = $index = 0;
    initTableau();
    echo '<br>';
    for($i = 0; $i < count($tableau['value']); $i++)
    {
        if($tableau['check'][$i] == true) continue;
        if($debugMode) echo '[findLargerGroup] Je teste la case '. $i.'<br>';
        checkDuplicate($i);
    }
    if($debugMode) echo 'nb de groupe au total : '.count($groupNum).'<br>';
    for($i = 0; $i < (count($groupNum));$i++)
    {
        if($debugMode) echo 'GroupNum testé index '.$i.'<br>';
        if(count($groupNum[$i]) > $total)
        {
            $total = count($groupNum[$i]);
            $index = $i;
        }
    }
    echo 'Le tableau le plus grand est le n°'. ($index+1) . ' avec '. $total . ' Valeurs'.'<br>';
    echo 'Le tableau comprend ['. implode(',',$groupNum[$index]).']'.'<br>';
}
/*
$file = fopen('php://stdin', 'r');
do {
    echo 'Veuillez écrire une largeur'. '<br>';
    $width = trim(fgets($file));
    echo 'Veuillez écrire une longueur'. '<br>';
    $length = trim(fgets($file));
    if(!preg_match('/[0-9]/', $width) || !preg_match('/[0-9]/', $length)) {
        echo '[ERREUR] Merci d\'entrer une valeur correcte'.'<br>';
        continue;
    }
    break;
}while(1 != 2);
$MAXVALUE = $width*$length;
$time_start = microtime(true);
findLargerGroup();
$time_end = microtime(true);
if($debugMode == 1) echo 'Temps d\'execution : '. ($time_end-$time_start);
*/

