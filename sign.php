<?php
require 'functions.php';

if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['re_password'])) {
	die('
		<script>
			alert("Preencha todos os campos.");
			location.href="index.php";
		</script>
	');
}

extract($_POST);

$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
$re_password = mysql_real_escape_string($re_password);

if($password != $re_password) {
	die('
		<script>
			alert("As senhas precisam ser iguais.");
			location.href="index.php";
		</script>
	');
}

$sql = "SELECT * FROM `users` WHERE `username`='".$username."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	die('
		<script>
			alert("Este usuário já existe.");
			location="index.php";
		</script>
	');
}

$sql = "SELECT `username` FROM `graveyard` WHERE `username`='".$username."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	die('
		<script>
			alert("Este usuário já existe.");
			location="index.php";
		</script>
	');
}

$sql = "INSERT INTO `users` (`username`, `password`) VALUES ('".$username."', '".$password."')";
query($sql);

echo"
	<script>
		alert('Conta criada com sucesso!');
		location.href='index.php';
	</script>
";
?>