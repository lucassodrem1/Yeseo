<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$enemy = new Enemy($_GET['i']);
$player->playerDie();
$player->exitBattle();

header('Location: ../../index.php');
?>