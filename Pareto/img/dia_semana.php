<?php
$fecha = date('2018-02-31');
$nuevafecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
echo $nuevafecha;

$year = 2018;
$month = 2;
$first_of_month = mktime (0,0,0, $month, 1, $year); 
echo $maxdays = date('t', $first_of_month);
?>