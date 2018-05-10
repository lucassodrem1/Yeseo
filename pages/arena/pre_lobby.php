<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inLobby();

$player->enterLobby();
header('Location: lobby.php');
?>