<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inLobby('lobby.php');

$player->enterLobby();
header('Location: lobby.php');
?>