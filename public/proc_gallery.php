<html>
    <body>
        <h1>Gallery.php</h1>
        

    

<?php
    echo '<form action="proc_gallery.php", method="POST">
    <b>Sort Mode:</b><br>';
    echo radioButton("sortMode","orig","Original");
    echo radioButton("sortMode","date_newest","Date Newest");
    echo radioButton("sortMode","date_oldest", "Date Oldest");
    echo radioButton("sortMode","size_largest","Size Largest");
    echo radioButton("sortMode","size_smallest","Size Smallest");
    echo radioButton("sortMode","rand","Random");

    echo "<b>Display Mode:</b><br>";
    echo radioButton("displayMode", "list", "List");
    echo radioButton("displayMode", "matrix", "Matrix");
    echo radioButton("displayMode", "details", "Details");

    echo '<input type="submit">';

    echo '</form>';

    if ($_POST["sortMode"] && $_POST["displayMode"]) {
        echo "<font color=\"blue\">DISPLAYING GALLERY ".$_POST["sortMode"].", ".$_POST["displayMode"].'</font><br>';
        proc_gallery("../data/gallery.csv", $_POST["displayMode"], $_POST["sortMode"]);
        
      }
function radioButton($name, $id, $label) {
    return '<input type="radio", id="'.$id.'", name="'.$name.'", value="'.$id.'"> <label for="'.$id.'">'.$label.'</label><br>';
}
class galleryImage {
    public $name = "";
    public $directory = "";
    public $description = "";
    public $weight = 0;

}

function getWeight($fileName, $mode, $index) {
    if ($mode == "orig") {
        return $index;
    }
    else if ($mode == "date_newest") {
        return filemtime($fileName);
    }
    else if ($mode == "date_oldest") {
        return -1*filemtime($fileName);
    }
    else if ($mode == "size_largest") {
        return filesize($fileName);
    }
    else if ($mode == "size_smallest") {
        return -1*filesize($fileName);
    }
    else if ($mode == "rand") {
        return random_int(0, 999);
    }
    return -1;
}
function proc_gallery($fileName, $mode, $sort_mode) {
    //$directory = substr($fileName, 0, strrpos($fileName, "/"));
    $directory = "";
    //echo $directory;
    $handle = fopen($fileName,"r") or die("Cannot open ".$fileName);


$row = 0;
$images = array();
while ($data = fgets($handle)) {

    $inQuote = '';
    $data_cols = [];
    

    $last = 0;
    for ($i = 0; $i < strlen($data); $i++) {
        if ($data[$i] == '"' || $data[$i] == "'") {
            if ($inQuote == '') {
                $inQuote = $data[$i];
            } else if ($inQuote == $data[$i]) {
                $inQuote = '';
            }
        }
        else if ($data[$i] == ',' || $data[$i] == '	') {
            //The "space" is actually tab
            if ($inQuote == '') {
                //Only split if not inside quotes
                $tmpStr = substr($data, $last, $i - $last);
                array_push($data_cols, $tmpStr);
                $last = $i+1;
                //+1 to skip the splitter character
            }
        }
    }
    array_push($data_cols, substr($data, $last));
    //Push last value

    
    $item = new galleryImage;
    $item->name = $data_cols[0];
    $item->directory = $directory.$item->name;
    $item->description = $data_cols[1];
    //echo $directory."/".$item->name;
    $item->weight = getWeight($item->directory, $sort_mode, $row);
    array_push($images, $item);
    
    $row+=1;
}

fclose($handle);

$images = sortImages($images);

echo "</table>\n<p/>";
    if ($mode == "matrix") {
        echo "<table> <tr>";
    }
    else if ($mode == "details") {
        echo "<ul>";
    }
    $index = 0;
    foreach ($images as $image) {
        if ($mode == "list") {
            echo '<img src="'. $image->name .'" alt="'.$image->directory.'" style="width:200px;height:200px;"><br>';
        }
        else if ($mode == "matrix") {
            
            if ($index%3 == 0) {
                echo "</tr><tr>";
            }
            $index+=1;
            echo '<td><img src="'. $image->name .'" alt="'.$image->directory.'" style="width:200px;height:200px;"></td>';
        }
        else {
            echo "<li>".$image->name.", ".$image->description."</li>";
        }
    }
    if ($mode == "matrix") {
        echo "</tr></table>";
    }
    else if ($mode == "details") {
        echo "</ul>";
    }
}
function sortImages($array) {
    $continue = true;
    while ($continue) {
        $continue = false;
        for( $i = 0; $i < count($array)-1; $i++ ) {
            $left = $array[$i];
            $right = $array[$i+ 1];
            if ($left->weight < $right->weight) {
                //echo $array[$i]->name;
                $array[$i] = $right;
                $array[$i+1] = $left;
                
                //Swap
                $continue = true;
            }
        }

    }
    return $array;
}
?>

</body>
</html>