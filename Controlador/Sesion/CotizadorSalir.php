<?php 
session_start(); 
session_destroy();         
header('Location:../../Vista/CotizacionKV.php');    
die;
?>