<html>

<!-- HEAD section ............................................................................ -->
<head>
  <title> Yoonsuck Choe's Experimental Web Site </title>


  <!-- javascript functions -->
  <script>
  function randText() {
      let randomBits = ["hello world", "random thoughts", "pinky and the brain"];
      document.getElementById("demo").innerHTML = randomBits[Math.floor(Math.random()*3)];
  }
  </script>

  <!-- style -->
 
  <!--
  <style>
    div.defaultFont {
        font-family: Helvetica, Arial, sans-serif;
    }
    
    div.secondaryFont {
        font-family: serif;
    }

    h3 {
        color: blue;
    }
    <link href="default.css" rel="stylesheet" type="text/css>
  </style> -->

  <LINK REL=StyleSheet HREF="simple.css" TYPE="text/css" MEDIA=screen>
  

</head>

<!-- BODY section ............................................................................. -->
<body>
<div class="defaultFont">

<h3>Search zone</h3>
<form action="search.php" method="post">
Search: <input type="text" name="name"> 
<input type="submit">

<!-- PHP testing area ................................ --> 
<?php
    require __DIR__."/proc_csv.php";
    require __DIR__."/proc_markdown.php";

   echo "<h1> Patrick Quinn 331 Project 1 </h1>\n";

   echo "<font color=\"green\"> Haha update and redeploy </font><p/>\n";
   echo " Testing PHP <br>\n";
   echo " Hello world!<p/>\n";

   echo "<h3>Testing file loading:</h3>\n";

   # FILE access 
   # $h = fopen("false.dat","r");

   proc_markdown("../data/markdown.md");

   echo "<h3>Columns 1 and 3 </h3>";
   proc_csv2("data.dat", "1:3");

   echo "<h3>All Columns </h3>";
   proc_csv2("data.dat", "ALL");

   echo "<h3>Doublequotes and commas </h3>";
   proc_csv2("../data/dat-doublequote-comma.csv", 'ALL');
   
   echo "<h3>Doublequotes and tabs </h3>";
   proc_csv2("../data/dat-doublequote-tab.csv", 'ALL');

   echo "<h3>Doublequotes and commas 2 </h3>";
   proc_csv2("../data/dat2-doublequote-tab.csv", 'ALL');

   echo "<h3>Doublequotes and tabs 2</h3>";
   proc_csv2("../data/dat2-doublequote-tab.csv", 'ALL');

   echo "<h3>Single quotes and tabs </h3>";
   proc_csv2("../data/dat2-doublequote-tab.csv", 'ALL');

   /*$handle = fopen("data.dat","r") or die("Cannot open data.dat");

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
            else if ($data[$i] == ',' || $data[$i] == '\t') {
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
        $row+=1;
   }

   fclose($handle);

   echo "</table>\n<p/>";
   

   echo "Debug: ";
   print_r($data_cols); 

   echo "<p/>";

   echo "rand : ".$data_cols[rand(0,1)]."\n";

   echo "<p/>";*/

?>


<!-- Java script testing area ............................... -->

<div class="secondaryFont"> 

<h3>Java script test</h3>

<p id="demo"> Content to be changed: </p> 

<button type="button" onclick="randText()">Click Me!</button>

<button onClick="window.location.reload();">Reload Page</button>

<p>For more javascript examples, see <a href="jstest.php">jstest.php</a>.</p>

</div>

<!-- HTML form input handling .......................... -->

<h3>HTML Form input test</h3>
<p/>
<form action="action.php" method="post">
Search: <input type="text" name="name"> 
<input type="submit">
</form>
<p/>

<h3>HTML Form input test 2 </h3>

Search academic genealogy (external link: <a href="https://www.mathgenealogy.org">https://www.mathgenealogy.org</a>): <p/>
<form action="https://www.mathgenealogy.org/query-prep.php" method="post">
Firstname:
<input type="text" name="given_name" value="Yoonsuck">  <br/>
Lastname:
<input type="text" name="family_name" value="Choe"> 
<input type="submit">
</form>
<p/>
</div> <!-- end of big div -->

<?php echo "Container IP Address:".getenv('MY_IP')."\n"; ?>
</body>

</html>

