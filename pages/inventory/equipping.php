<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$equip = new Equip();
$equip->load($_GET['i']);

$player->equipping($equip);
header('Location: bag.php');
?>