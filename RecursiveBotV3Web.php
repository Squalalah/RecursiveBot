<?php

$tableau = array();
$groupNum = array();
$widthTabIncrement = array();
$widthTabDecrement = array();
$MINVALUE = 0;


?>

<form method="POST" action="#">
    <label for="width">Largeur : </label>
    <input type="number" name="width" id="width" min="1" value="5"><br>
    <label for="length">Longueur : </label>
    <input type="number" name="length" id="length" min="1" value="5"><br>
    <label for="debug">DebugMode : </label>
    <input type="number" name="debug" id="debug" min="0" max="1" value="1"><br>
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

function checkDuplicate($index, $key = null, $parentIndex = null): ?array {
    global $tableau, $groupNum, $MAXVALUE, $MINVALUE, $width, $widthTabIncrement, $widthTabDecrement, $debugMode;
    $numbers = array();
    if($debugMode) {
        if($parentIndex != null) echo '[checkDuplicate] Je teste la case ' .($index). 'via la case '.$parentIndex.'<br>';
        else echo '[checkDuplicate] Je teste la case ' .$index.'<br>';
    }
    if($tableau['check'][$index] == true) return null;
    $tableau['check'][$index] = true;
    if($tableau['value'][$index] == 1)
    {
        if($key === null) $key = count($groupNum);
        if($debugMode) echo '[checkDuplicate] La case '. $index. ' est un 1, je l`\'ajoute au tableau '.$key.'<br>';
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
    echo '<br>';
}

function showResult($groupNum) : void {
    global $debugMode;
    $groupResult = array();
    $total = 0;
    $index = array();
    if($debugMode) echo 'nb de groupe au total : '.count($groupNum).PHP_EOL;
    for($i = 0; $i < count($groupNum);$i++)
    {
        if($debugMode) echo 'TEST n??: '. $i.PHP_EOL;
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
    $str = 'R??sultats : '.PHP_EOL;
    if(count($groupResult) >= 1)
    {
        for($a = 0; $a < count($groupResult); $a++) {
            $str .= '[Tableau n??'.($index[$a]+1).' avec '.$total. ' valeurs]'.PHP_EOL;
        }
        echo $str;
    }
    else echo 'Il n\'y a aucun 1, donc aucun tableau';
}



