<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);

if(!isset($_GET['i'])) {
	die('Erro.');
}

$enemy = new Enemy($_GET['i']);
$playerDied = $_GET['p'];
$enemyDied = $_GET['e'];

if($playerDied == 0 && $enemyDied != 1) {
	die('
		<script>
			alert("Você não matou o inimigo ainda.");
			location.href="arena.php";
		</script>
	');	
}

if($playerDied == 0 && $enemyDied == 1) {
	$player->enemyZoneDie($enemy);
	$player->exitBattle();
	header('Location: lobby.php');
} else {
	$player->exitBattle();
	$player->exitLobby();
	$player->playerDie();
	header('Location: ../../index.php');
}
?>