<?php
$source_id = $_GET['source_id'];
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
$sql = "SELECT SUM(freq) as tot FROM occurrence WHERE source_id = ? AND word != ''";
$statement = $pdo->prepare($sql);
$statement->bindParam(1, $source_id);
$statement->execute();
$crow = $statement->fetch();
$count = $crow[tot];
$sql = "SELECT word, freq FROM occurrence WHERE source_id = ? AND word != '' ORDER BY freq DESC";
$statement = $pdo->prepare($sql);
$statement->bindParam(1, $source_id);
$statement->execute();
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
    <title>Detailed Report</title>
</head>
<body>
<div id="globnavbar"></div>
    <h1 id = "detailedReporth1">Detailed Report</h1>
<table>
    <tr>
        <th>Word</th>
        <th>Frequency</th>
        <th>Percentage</th>
    </tr>
    <?php 
        foreach($statement as $row){
            $percent = $row[freq]/$count * 100;
            echo "<tr><td>$row[word] </td><td> $row[freq] </td> <td> $percent %</td></tr>";
        }
    ?>
</tr>
</table>
</body>
</html>