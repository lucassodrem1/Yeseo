<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$enemy = new Enemy($player->getActualFloor());
$player->inBattle();

//Verifica se o player já lutou contra esse boss.
if($player->getMaxFloor() > $enemy->getID()) {
	die('
		<script>
			alert("Você já lutou contra esse boss.");
			history.back();
		</script>
	');
}

//Verifica se o user é o líder do lobby em que está.
$sql = "SELECT `leader_id` FROM `lobby` WHERE `player_id`='".$player->getID()."'";
$query = query($sql);
$row = mysql_fetch_assoc($query);
if($row['leader_id'] != $player->getID()) {
	die('
		<script>
			alert("Você não é o líder do lobby.");
			history.back();
		</script>
	');
}

$player->enterArena($enemy);
header('Location: arena.php');
?>