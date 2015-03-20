<?php
ini_set('display_errors', 0);
session_start();

$_SESSION[$_GET['var']] = $_GET['val'];
$msg = $_GET['var'] . " / " . $_GET['val']. " / " . $_SESSION['logged_in'];

//addTolog($_GET['var']. " " . $_GET['val']);
/*
// troubleshooting:

foreach($_SESSION['profile'] as $key => $value){
$msg .= $key . " => " . $value . "
";
}

echo $msg; */
?>
