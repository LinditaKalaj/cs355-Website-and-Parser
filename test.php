<?php

$string = file_get_contents('https://www.gutenberg.org/cache/epub/68702/pg68702.html');
function wp_strip_all_tags( $string, $remove_breaks = false ) {
    $string = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
    $string = strip_tags( $string );
 
    if ( $remove_breaks ) {
        $string = preg_replace( '/[\r\n\t ]+/', ' ', $string );
    }
 
    return trim( $string );
}
$string = wp_strip_all_tags($string);
echo $string;
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
    <h1 id = "parseResultsh1">Test</h1>
    <div><p id = cparse>Here are the results of this parse, if you would like to view parse history 
        click <a href="report.php">HERE</a></p></div>
    </body>
</html>
