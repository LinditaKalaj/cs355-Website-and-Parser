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