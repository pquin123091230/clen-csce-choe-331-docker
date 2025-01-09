<html>

<head>
  <LINK REL=StyleSheet HREF="simple.css" TYPE="text/css" MEDIA=screen>
</head>

<body>

<h1>Fetch.php</h1>

<p>
Fetch and display HTML code from a URL. 
</p>

<ol>
<li> This can be used for your search and highlight function. 
<li> Note that this may be just one way of doing this. 
<li> You can look for other ways. 
<li> This was tested on both docker and Infinityfree.
<li> You may use any PHP built in function for URL validation, HTML code tag removal, etc. etc.
</ol>

<p/>

<?php

########################################
# fetch_html function
########################################
function fetch_html($url) {

# check if $url is valid URL, not malicious code, then fetch and print
#if (true) { #filter_var($url,FILTER_VALIDATE_URL)) {
if (filter_var($url,FILTER_VALIDATE_URL)) {

  echo getcwd()."/$url";

  echo "<pre class=\"code\">\n";

  # PHP system call to get html from URL
#  $html = file_get_contents(getcwd().$url);  
   $html = file_get_contents($url);  

  # Repalce HTML tags
  #$html = preg_replace("/</","[",$html);
  #$html = preg_replace("/>/","]",$html);

  $doc = new DOMDocument();
  $doc->loadHTML($html);
  $match = $doc->getElementsByTagName("*");
  echo "<pre>" ; 
  echo "match\n";

  $count = 0;
  foreach ($match as $content) {
    echo "[$count]======================================================================= \n"; 
    ++$count;
    echo $content->nodeValue, PHP_EOL;
    $content->nodeValue = "Howdy";
    $content->textContent= "Howdy";
    //$content->nodeValue = "HELLO";
  }
  #$doc->getElementsByTagName("*")[0].nodeValue = "HELLO"; 
  echo "content\n";
  print_r($content) ; 
  echo "</pre>";

  echo '[$doc->saveHTML() ===============================================================\n';
  echo $doc->saveHTML();
  
  echo '[$html ===============================================================\n';
  echo "$html\n";
  echo "</pre>\n";

} else {

  echo "<pre class=\"code\">\n";
  echo "<pre>Warning: [$url] is empty or not a valid URL.</pre>\n";
  echo "</pre>\n";

}

}

?>

<p/>

<!-- GET form method testing area ................................ --> 
<form action="fetch.php" method="get">
Enter URL to fetch: <input type="text" name="url">
<input type="Submit">
</form>

<?php

echo "<h3> Fetch result </h3>\n";

# Test function call
fetch_html($_GET["url"]);


?>

</body>
</html>
