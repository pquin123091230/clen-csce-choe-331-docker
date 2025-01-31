<?php

function strGet($string, $index) {
    if ($index < 0 || $index >= strlen($string)) {
        return '';
    }
    else {
        return $string[$index];
    }
}
function substrAt($string, $substr, $index) {
    for ($i = 0; $i < strlen($substr); $i++) {
        if ($i+$index >= strlen($string)) {
            return false;
        }
        else if ($substr[$i] != $string[$i+$index]) {
            return false;
        }
    }
    return true;
}

function numPreceding($string, $substr, $index) {
    $t = $index;
    $num = 0;
    while ($t >= 0) {
        if ($string[$t] == $substr) {
            $num++;
        }
        else {
            return $num;
        }
        $t-=1;
    }
    return $num;
}
function proc_markdown($fileName) {
    $handle = fopen($fileName,"r") or die("Cannot open ".$fileName);

    echo "<p>\n";

    $row = 0;
    $headingLevel = 0;
    $start = 0;
    $current = 0;
    $end = 0;
    $listOrdered = False;
    $listNum = 0;
    $listStartIndex = 0;
    $listing = False;
    $newlines = 0;
    while ($data = fgets($handle)) {
        
            $start = 0;
            $current = 0;
            $headingLevel = 0;
            $bold = False;
            $italic = False;
            $tStr = "";
            $listing = False;
            
            while ($current < strlen($data)) {
                if ($data[$current] == "\n") {
                    if ($current <= 2) {
                        echo "<p>";
                    }
                }
                if ($data[$current] == "#") {
                    if (strGet($data, $current+1) == "#") {
                        if (strGet($data, $current+2 ) == "#") {
                            //heading 1
                            $headingLevel = 3;
                            $current+=2; //skip
                        }
                        else {
                            //heading 2
                            $headingLevel = 2;
                            $current+=1;
                        }
                        
                    }
                    else{
                        // heading 3
                        $headingLevel = 1;
                    }
                    $start = $current+1;

                    
                }
                else if ($data[$current] == "*" && strGet($data, $current+1) == "*") {
                    $bold = !$bold;
                    $current+=1;
                    if ($bold) {
                        $tStr = $tStr."<b>";
                    }
                    else {
                        $tStr = $tStr."</b>";
                    }
                }
                else if ($data[$current] == "_") {
                    $italic = !$italic;
                    if ($italic) {
                        $tStr = $tStr."<i>";
                    }
                    else {
                        $tStr = $tStr."</i>";
                    }
                }
                else if (substrAt($data, "![", $current)) {
                    $closeIndex = strpos($data, "]", $current+1);
                    $linkStart = strpos($data, "(", $current+1)+1;
                    $linkEnd = strpos($data, ")", $current+1);
                    $linkStr = substr($data, $linkStart, $linkEnd-$linkStart);
                    $dispStr = substr($data, $current+1, $closeIndex-$current-1);
                    $tStr = $tStr.'<img src="'.$linkStr.'" alt="'.$dispStr.'">';
                    $current = $linkEnd; //skip
                }
                else if ($data[$current] == "[") {
                    $closeIndex = strpos($data, "]", $current+1);
                    $linkStart = strpos($data, "(", $current+1)+1;
                    $linkEnd = strpos($data, ")", $current+1);
                    $linkStr = substr($data, $linkStart, $linkEnd-$linkStart);
                    $dispStr = substr($data, $current+1, $closeIndex-$current-1);
                    $tStr = $tStr.'<a href="'.$linkStr.'">'.$dispStr."</a>";
                    $current = $linkEnd; //skip
                }
                else if ($data[$current] == "*") {
                    $listing = True;
                    $listOrdered = False;
                    $numSpaces = numPreceding($data, " ", $current-1);
                    $end = strpos($data, "\n", $current+1);
                    $dispStr = substr($data, $current+1, $end-$current-1);
                    
                    if ($numSpaces > $listStartIndex) {
                        $tStr = $tStr."<ul>";
                        $listStartIndex = $numSpaces;
                        $listNum+=1;
                    }
                    else if ($numSpaces < $listStartIndex) {
                        $tStr = $tStr."</ul>";
                        $listStartIndex = $numSpaces;
                        $listNum-=1;
                    }
                    else {
                        
                    }
                    $tStr = $tStr."<li>".$dispStr."</li>";
                    $current = $end;
                }
                else if (($data[$current] == "1" && strGet($data, $current+1) == ".")) {
                    $listing = True;
                    $numSpaces = 1;
                    $end = strpos($data, "\n", $current+1);
                    $dispStr = substr($data, $current+2, $end-$current-1);
                    $listOrdered = True;
                    
                    if ($numSpaces > $listStartIndex) {
                        $tStr = $tStr."<ol>";
                        $listStartIndex = $numSpaces;
                        $listNum+=1;
                    }
                    else if ($numSpaces < $listStartIndex) {
                        $tStr = $tStr."</ol>";
                        $listStartIndex = $numSpaces;
                        $listNum-=1;
                    }
                    else {
                        
                    }
                    $tStr = $tStr."<li>".$dispStr."</li>";
                    $current = $end;
                }
                else if ($data[$current] == "-" && $listStartIndex == 1 && $listOrdered) {
                    //ordered list nest
                    $listing = True;
                    $listOrdered = True;
                    $numSpaces = 2;
                    $end = strpos($data, "\n", $current+1);
                    $dispStr = substr($data, $current+1, $end-$current-1);
                    if ($numSpaces > $listStartIndex) {
                        $tStr = $tStr."<ol>";
                        $listStartIndex = $numSpaces;
                        $listNum+=1;
                    }
                    else if ($numSpaces < $listStartIndex) {
                        $tStr = $tStr."</ol>";
                        $listStartIndex = $numSpaces;
                        $listNum-=1;
                    }
                    else {
                        
                    }
                    $tStr = $tStr."<li>".$dispStr."</li>";
                    $current = $end;
                }
                else {
                    $tStr = $tStr.$data[$current];
                }
                $current+=1;
                
            }
            if (!$listing) {
                while ($listNum > 0) {
                    $listNum -=1;
                    if ($listOrdered) {
                        echo "\n</ol>";
                    }
                    else {
                        echo "\n</ul>";
                    }
                }
                $listStartIndex = 0;
            }
            if ($headingLevel > 0) {
                echo "<h".$headingLevel.">";
            }
            echo $tStr; // substr($data, $start, $current-$start);
            if ($headingLevel > 0) {
                echo "</h".$headingLevel.">";
            }
        }
    fclose($handle);
}
?>