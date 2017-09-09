<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title>Tulevat ravit  ja tapahtumat scraper</title>
 </head>
<body>
<div style='border: thin solid black; background-color : #c0c0c0; width:300px;'>
<?php
include 'simple_html_dom.php'; 
$string = file_get_contents('http://www.yle.fi/tekstitv/txt/P469_01.html'); // Yletxt 469 url

$html = str_get_html($string);

$data = $html->find('pre', 1); // Toka <pre> tagi parsetaan
$number_regex = '/\d{1}\/\d{1,2}/';
$time_regex = '/(\d{1,2}\:\d{1,2})/';
$blank_rows = '/^\h*\v+/m';
$aby_regex = '/(&Aring;by \(\d{2}\))/';
$t_regex = '/(T\d{1,2})\s/';
$data = preg_replace($number_regex, '', $data); // Sivunumerointi pois
$data = preg_replace($blank_rows, '', $data); // Tyhjät rivit

$data = strip_tags($data, '<pre>'); // Tagit pois
$data = str_replace('           Tulevat tapahtumat        ', '', $data); // Ylin rivi pois
$data = str_replace(' pvm    ', 'pvm    ', $data); // Sijainti kohdilleen
$data = str_replace(' rata', '    rata', $data); // Sijainti kohdilleen
$data = str_replace(' Toto', 'T', $data); // Toto -> T
$data = preg_replace($t_regex, '\1', $data); // "TXX "-> "TXX"
$data = preg_replace($aby_regex, '\1       ', $data); // Åbyfix
//$data = preg_replace('/((\b[a-zA-Z]{3}\b \(\d{2}\))/', '\1       ', $data); // Muut 3 merkkiset

$data = str_replace('   460 RAVIEN OTSIKOT   ', '', $data); // Pois
$data = str_replace('                      ', '', $data); // Tyhjää
$data = str_replace('                    ', '', $data); // Tyhjää
$data = str_replace('                ', '', $data);
$data = str_replace('kello 9     ', 'kello 9', $data); // Tyhjää
$data = str_replace(')        ', ') ', $data); // Tyhjää



echo $data;

?>
</div>
</body>
</html>