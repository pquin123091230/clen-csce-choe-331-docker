<?php
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
    $directory = substr($fileName, 0, strrpos($fileName, "/"));
    //echo $directory;
    $handle = fopen($fileName,"r") or die("Cannot open ".$fileName);

echo "<table  border=\"1\">\n";

$row = 0;
$images = array();
while ($data = fgets($handle)) {
    
    echo "<tr>\n";
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

    //$data_cols = preg_split('/,/',$data);
    for ($k=0; $k<count($data_cols); ++$k) {
        if ($row == 0) {
            echo "  <td> <h3>".$data_cols[$k]."</h3></td>\n";
        }
        else {
            echo "  <td> ".$data_cols[$k]." </td>\n";
        }
    }
    echo "</tr>\n";
    $item = new galleryImage;
    $item->name = $data_cols[0];
    $item->directory = $directory."/".$item->name;
    $item->description = $data_cols[1];
    //echo $directory."/".$item->name;
    $item->weight = getWeight($item->directory, $sort_mode, $row);
    array_push($images, $item);
    
    $row+=1;
}

fclose($handle);

$images = sortImages($images);
for ($i = 0; $i < count($images); $i++) {
    echo $images[$i]->name.",".$images[$i]->weight."<br>";
}

echo "</table>\n<p/>";
    foreach ($images as $image) {
        if ($mode == "list") {
            echo "<img src=". $image->directory ." alt=".$image->directory."><br>";
        }
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