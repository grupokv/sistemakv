<?php
// include QR_BarCode class 
include "qr_google.php"; 

// QR_BarCode object 
$qr = new QR_BarCode(); 
/*

// save QR code image
$qr->qrCode(350,'images/cw-qr.png');
*/
// create url QR code 
$qr->url('http://www.ortsas.com/comprobar.php?ID=4255373022018142900001');

/*
// create text QR code 
$qr->text('textContent');

// create email QR code 
$qr->email('emailAddress', 'subject', 'message');

/*
// create phone QR code 
$qr->phone('phoneNumber');

// create sms QR code 
$qr->sms('phoneNumber', 'message');

*/
/*
// create contact QR code 
$qr->contact('name', 'address', 'phone', 'email');

// create content QR code 
$qr->content('type', 'size', 'content');
*/

// display QR code image
$qr->qrCode();
?>