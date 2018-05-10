<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$enemy = new Enemy($_GET['i']);
$player->enemyDie($enemy);
$player->exitBattle();

header('Location: ../home.php');
?>