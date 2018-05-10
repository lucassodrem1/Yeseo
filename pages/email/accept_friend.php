<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);

//Identificando mensagem.
$sql = "SELECT * FROM `messages` WHERE `id`='".$_GET['i']."'";
$query = query($sql);
$message = mysql_fetch_assoc($query);

//Fazendo amizade.
$sql = "INSERT INTO `player_friends` (`player_id`, `friend_id`) VALUES ('".$player->getID()."', '".$message['sender_id']."')";
query($sql);

$sql = "INSERT INTO `player_friends` (`player_id`, `friend_id`) VALUES ('".$message['sender_id']."', '".$player->getID()."')";
query($sql);

//Apagando mensagem.
$sql = "DELETE FROM `messages` WHERE `id`='".$message['id']."'";
query($sql);

header('Location: messages.php');
?>