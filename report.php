<?php
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
$sql = "SELECT * FROM source";
$statement = $pdo->query($sql);
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
    <title>General Reports</title>
</head>
<body>
<div id="globnavbar"></div>
    <h1 id = "GeneralReporth1">General Reports</h1>
    <table>
    <tr>
        <th>Source ID</th>
        <th>Source Name</th>
        <th>Source URL</th>
        <th>Source Begin</th>
        <th>Source End</th>
        <th>Parsed Date</th>
        <th>Words</th>
    </tr>
    <?php 
        foreach($statement as $row){
            $source_id = $row[source_id];
            
            echo "<tr>
                        <td>$row[source_id] </td>
                        <td>$row[source_name] </td> 
                        <td> <a href=$row[source_url]>$row[source_url]</a> </td>
                        <td> $row[source_begin] </td>
                        <td> $row[source_end] </td>
                        <td> $row[parsed_dtm] </td>
                        <td><a href=\"detailedreport.php?source_id=$source_id?>\">Detailed report</a></td>
                    </tr>";
        }
    ?>
</tr>
</table>
</body>
</html>