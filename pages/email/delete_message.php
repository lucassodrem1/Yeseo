<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();

$sql = "DELETE FROM `messages` WHERE `id`='".$_GET['i']."'";
query($sql);

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>