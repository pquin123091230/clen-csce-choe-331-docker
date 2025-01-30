<html>
<body>

<h1>Search.php</h1>

This page can be called by other PHP scripts or from itself. 

<h3>Search zone</h3>
<form action="search.php" method="post">
Search: <input type="text" name="name"> 
<input type="submit">

</body>
</html>


<p/>



<?php
function search($string)  {
    $s = "";
    for ($i = 0; $i < strlen($string); $i++) {
        if (ctype_alnum($string[$i])) {
            $s = $s.$string[$i];
        }
    }
    //find the webpages
    $pages = array();
    array_push($pages, "index.php","search.php","action.php","fetch.php");

    $results = array();
    for ($i = 0; $i < count($pages); $i++) {
        $d = file_get_contents($pages[$i]);
        #echo $d;
        if (!$d) {
            echo "bad file: ".$pages[$i];
        }
        else {
            $doc = new DOMDocument();
            $doc->loadHTML($pages[$i]);
            if (strpos($doc->saveHTML(), $s)) {
                array_push($results, $pages[$i]);
            }
        }
    }

    return $results;
}

if ($_POST["name"]) {
    echo "<font color=\"blue\">Search Results for '".$_POST["name"]."'</font>\n<br>";
    $result = search($_POST["name"]);
    for ($i = 0; $i < count($result); $i++) {
        echo '<a href="'.$result[$i].'">'.$result[$i].'</a><br>';
    }
    if (count($result) > 0) {
        $d = file_get_contents($result[0]);
        $doc = new DOMDocument();
        $doc->loadHTML($d);
        echo $d;
    }
  }
?>

<p/>

