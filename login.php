<?php
require_once 'functions.php';

if(empty($_POST['user']) || empty($_POST['pass'])) {
	die('
		<script>
			alert("Preencha todos os campos.");
			location.href="index.php";
		</script>
	');
}

extract($_POST);

$user = mysql_real_escape_string($user);
$pass = mysql_real_escape_string($pass);

$sql = "SELECT * FROM `users` WHERE `username`='".$user."' AND `password`='".$pass."'";
$query = query($sql);
if(mysql_num_rows($query) == 0) {
	die('
		<script>
			alert("Usuário ou senha incorreta.");
			location.href="index.php";
		</script>
	');
}

$row = mysql_fetch_assoc($query);
$info = $row['id'] . ' - ' . $row['username'] . ' - ' . $row['password'];
setcookie('info', $info, time() + 60 * 60 * 2);
header('Location: pages/home.php');
?>