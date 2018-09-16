<?php
class TextUtility{
    public static function summarize($string, $count){
    //explode the string into the array words, separated by space " "
    $words = explode(" ", $string);
    $length = count($words);
    $result = array();
    $counter = 0;
    foreach($words as $word){
        if($counter <$count){
            array_push($result, $word);
            $counter++;
        }
    }
    //return summary plus horizontal ellipsis
    //implode the array $result into a string, separated by " " + "... " symbol
    return implode(" ",$result). "&hellip;";
    }
}
?>