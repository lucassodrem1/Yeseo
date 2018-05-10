<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);

//Identificando mensagem.
$sql = "SELECT * FROM `messages` WHERE `id`='".$_GET['i']."'";
$query = query($sql);
$message = mysql_fetch_assoc($query);

//Apagando mensagem.
$sql = "DELETE FROM `messages` WHERE `id`='".$message['id']."'";
query($sql);

header('Location: messages.php');
?>