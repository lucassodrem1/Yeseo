<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$stats = $player->getStats();

extract($_POST);

//Verifica se possui pontos suficientes.
$usedPoints = $str + $int + $agi + $dex + $luk;
if($usedPoints > $player->getStatsPoints()) {
	die("
		<script>
			alert('Você não tem pontos suficientes.');
			location.href='perfil.php';
		</script>	
	");
}

//Aumentando stats.
$stats->strength += $str;
$stats->intelligence += $int;
$stats->agility += $agi;
$stats->dexterity += $dex;
$stats->lucky += $luk;

$sql = "UPDATE `users` SET `strength`='".$stats->strength."', `intelligence`='".$stats->intelligence."', `agility`='".$stats->agility."', `dexterity`='".$stats->dexterity."', `lucky`='".$stats->lucky."' WHERE `id`='".$player->getID()."'";
query($sql);

$playerPoints = $player->getStatsPoints() - $usedPoints;
$sql = "UPDATE `users` SET `stats_points`='".$playerPoints."' WHERE `id`='".$player->getID()."'";
query($sql);

header('Location: perfil.php');
?>