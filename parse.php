<?php

$name = $_POST["source_name"];
$url = $_POST["source_url"];
$begin = $_POST["source_begin"];
$end = $_POST["source_end"];

$servername = "mars.cs.qc.cuny.edu";
$username = "kali1197";
$password = "12131197";

try {
  $pdo = new PDO("mysql:host=$servername;dbname=kali1197", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
$url = filter_var($url, FILTER_SANITIZE_URL);
if (!filter_var($url, FILTER_VALIDATE_URL)){
    die("<img src=\"img/cat-screaming-cat.gif\" alt=\"scereaming cat\">STOP");
}
$string = file_get_contents($url);
$string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
$string = strip_tags( $string );
if ( $remove_breaks ) {
    $string = preg_replace( '/[\r\n\t ]+/', ' ', $string );
}
$string = trim($string);

if($begin && $end){
    $posBegin = strpos($string, $begin);
    $posEnd = strpos($string, $end);
    //echo $posBegin;
    //echo $posEnd;
    $string = substr($string, $posBegin, $posEnd - $posBegin + strlen($end));
}
elseif($begin){
    $posBegin = strpos($string, $begin);
    $string = substr($string, $posBegin);
}
elseif($end){
    $posEnd = strpos($string, $end);
    $string = substr($string, 0, $posEnd - $posBegin + strlen($end));
}
$string = preg_replace('/\p{P}/', '', $string);
$string = strtoupper($string);
$string_pieces = preg_split('/[\s]+/', $string);
$count_arr = array();
foreach($string_pieces as $word){
    if(!$count_arr[$word]){
        $count_arr += [$word => 1];
    }
    else{
        $count_arr[$word] += 1;
    }
}
arsort($count_arr);
$sql = "INSERT INTO source (source_name, source_url, source_begin, source_end)
VALUES (?, ?, ?, ?)";
$statement = $pdo->prepare($sql);
$params = [ $name, $url, $begin, $end ];
$statement->execute($params);
$source_id = $pdo->lastInsertId();
foreach($count_arr as $key => $val){
    $sql = "INSERT INTO occurrence (source_id, word, freq)
    VALUES (?, ?, ?)";
    $statement = $pdo->prepare($sql);
    $params = [ $source_id, $key, $val ];
    $statement->execute($params);
}

date_default_timezone_set('America/New_York');
$date = date('m-d-y h:i:s');



$conn = null;
?>
<!DOCTYPE html> 
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script> 
        $(function(){
            $("#globnavbar").load("navbar.html"); 
        });
        </script> 
    <title>Parse</title>
</head>
<body>
<div id="globnavbar"></div>
    <h1 id = "parseResultsh1">Parsing Complete!</h1>
    <div><p id = cparse>Here are the results of this parse, if you would like to view parse history 
        click <a href="report.php">HERE</a></p></div>
    <div>
    <table >
  <tr>
    <th>Source ID:</th>
    <td><?php echo $source_id ?></td>
  </tr>
  <tr>
    <th>Source Name:</th>
    <td><?php echo $name ?></td>
  </tr>
  <tr>
    <th>Source URL:</th>
    <td><a href=<?php echo $url ?>><?php echo $url ?></td>
  </tr>
  <tr>
    <th>Source Begin:</th>
    <td><?php echo $begin ?></td>
  </tr>
  <tr>
    <th>Source end:</th>
    <td><?php echo $end ?></td>
  </tr>
  <tr>
    <th>Parsed Date:</th>
    <td><?php echo $date ?></td>
  </tr>
  <tr>
    <th>Words URL:</th>
    <td><a href="detailedreport.php?source_id=<?=$source_id?>">Detailed report</a></td>
  </tr>
</table>
    </div>
</body>
</html>