<?php
include "../koneksi.php";

$username = $_POST['username'];
//$password = $_POST['password']; 
$password = md5($_POST['password']); 

$sql = "SELECT * 
	FROM user u 
	LEFT JOIN pegawai p ON p.id_peg=u.id_peg
	WHERE username = '$username' AND password = '$password'";
if(!$result = $db->query($sql)){
	die('There was an error running the query [' . $db->error . ']');
	}
$login_cek=$result->fetch_assoc();
$cek_name = $login_cek['username'];
$cek_pass = $login_cek['password'];

if ($cek_name == $username AND $cek_pass == $password) 
{
	session_start(); 
	$_SESSION['username'] = $username;
	header("location:../admin/index.php"); 
}
else 
{
	header("location:../index.php?error");  
}

?>