<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();

//Verifica se o user é o líder do lobby em que está.
$sql = "SELECT `leader_id` FROM `lobby` WHERE `player_id`='".$player->getID()."'";
$query = query($sql);
$row = mysql_fetch_assoc($query);
if($row['leader_id'] != $player->getID()) {
	die('Você não é o líder do lobby atual.');
}

//PRINCIPAL DIFERENÇA ENTRE A AREMA E A ZONE. A ARENA DA O ID DO BOSS ID DA TABLE FLOOR, NA ZONE O ENEMY SERÁ SORTEADO ENTRE OS ENEMIES DA TABLE FLOOR ENEMIES.
//Sortendo mob, todo o andar tem 3 mobs(70%, 25%, 5%).
$random = rand(1, 100);
if($random <= 5) {
	$sql = "SELECT * FROM `floor_enemies` WHERE `floor_id`='".$player->getActualFloor()."' AND `chance`='5'";
	$query = query($sql);
	$row = mysql_fetch_assoc($query);
	$enemy = new Enemy($row['enemy_id']);
	$player->enterArena($enemy);
} else if($random > 5 && $random <= 30) {
	$sql = "SELECT * FROM `floor_enemies` WHERE `floor_id`='".$player->getActualFloor()."' AND `chance`='25'";
	$query = query($sql);
	$row = mysql_fetch_assoc($query);
	$enemy = new Enemy($row['enemy_id']);
	$player->enterArena($enemy);
} else if($random > 30) {
	$sql = "SELECT * FROM `floor_enemies` WHERE `floor_id`='".$player->getActualFloor()."' AND `chance`='70'";
	$query = query($sql);
	$row = mysql_fetch_assoc($query);
	$enemy = new Enemy($row['enemy_id']);
	$player->enterArena($enemy);
}

header('Location: arena.php');
?>