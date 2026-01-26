<?php
session_start();
session_destroy();
echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.location.href='index.php';
		</SCRIPT>");
?>