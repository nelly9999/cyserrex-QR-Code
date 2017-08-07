<?php
$my['host'] = "localhost";
$my['user'] = "root";
$my['pass'] = "";
$my['dbs'] = "presensi";

$db = new mysqli($my['host'],$my['user'],$my['pass'],$my['dbs']);

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}  
?>
