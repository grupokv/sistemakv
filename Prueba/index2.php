<?php
ini_set("include_path", '/home/wwsist/php:' . ini_get("include_path") );
require_once "Mail.php";

$_mailbox        =   Mail::factory('smtp', array(
  'host'         => 'smtp.gmail.com',
  'auth'         =>  false,
  'port'         => '587',
  'debug'        => TRUE,
  'secure'             => 'tls',
  'username'     => 'dragonkyle@gmail.com',
  'password'     => 'Polar*1984*',
  'persist'      =>  FALSE  ));
  

$_boundary       =   sha1(date('r'));

$_headers        =   array(
  'From'         => 'JP <dragonkyle@gmail.com>',
  'To'           => 'juanr84@live.com',
  'Subject'      => 'consuming too much pear',
  'Content-Type' => 'multipart/related; boundary=DeS-mixed-{$_boundary}',
  'MIME-Version' => '1.0'    );

$_inline_img     =   chunk_split( base64_encode( file_get_contents("css/109612.png")));

$_eml_body       =<<<HDS
--DeS-mixed-{$_boundary}
Content-Type: multipart/alternative; boundary="DeS-alt-{$_boundary}"

--DeS-alt-{$_boundary}
Content-Type: text/plain

This is what I look like after consuming pear

--DeS-alt-{$_boundary}
Content-Type: multipart/related;
  boundary="DeS-related-{$_boundary}"

--DeS-alt-{$_boundary}
Content-Type: text/html

<b>This is what I look like after consuming pear</b>
<br><img src="cid:DeS-CID-{$_boundary}" border=0 />

--DeS-related-{$_boundary}
Content-Type: image/jpeg
Content-Transfer-Encoding: base64
Content-ID: <DeS-CID-{$_boundary}>

{$_inline_img}
--DeS-related-{$_boundary}--

--DeS-alt-{$_boundary}--

--DeS-mixed-{$_boundary}--
HDS;

$_to_eml  =  $_headers['To'];

$_mail    =  $_mailbox->send( $_to_eml, $_headers, $_body );

if    (PEAR::isError($_mail)) {

  echo date( " Y-m-d H:i:s  ->  " ) . "email to {$_to_eml} failed, details : " . $_mail->getMessage() . "\n\n";  }
else  {
  echo date( " Y-m-d H:i:s  ->  " ) . "email sent to {$_to_eml} !\n\n";    }

?>