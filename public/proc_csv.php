<?php
function proc_csv2($fileName, $columns) {
    $realColumns = [];
    if ($columns == "ALL") {
        $realColumns = [-1];
    }
    else{
        $columns = preg_split("/:/", $columns);
        foreach ($columns as $column) {
            array_push($realColumns, intval($column)-1);
        }
    }
    $handle = fopen($fileName,"r") or die("Cannot open ".$fileName);

echo "<table  border=\"1\">\n";

$row = 0;
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
        if (in_array($k, $realColumns) || in_array(-1, $realColumns)) {
            if ($row == 0) {
                echo "  <td> <h3>".$data_cols[$k]."</h3></td>\n";
            }
            else {
                echo "  <td> ".$data_cols[$k]." </td>\n";
            }
        }
    }
    echo "</tr>\n";
    $row+=1;
}

fclose($handle);

echo "</table>\n<p/>";

}
?>