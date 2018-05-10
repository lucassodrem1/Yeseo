<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$enemy = new Enemy($_POST['enemyID']);
$arena = new Arena($player->getID());
$playerCurrentStats = $arena->getPlayerCurrentStats();
$playerCurrentMP = $_POST['playerCurrentMP'];

//Redução HP do enemy.
$sql = "UPDATE `player_enemies` SET `enemy_current_hp`='".$_POST['enemyCurrentHP']."' WHERE `player_id`='".$player->getID()."'";
query($sql);

//Redução do contador.
$sql = "UPDATE `player_enemies` SET `enemy_current_time`='".$_POST['enemyCountDown']."' WHERE `player_id`='".$player->getID()."'";
query($sql);

//Gasto de MP
$sql = "UPDATE `player_enemies` SET `player_current_mp`='".$playerCurrentMP."' WHERE `player_id`='".$player->getID()."'";
query($sql);

//Fazendo a mudança de atributos.
//Verifica se a skill é AOE. Se for, altero os stats de todos os playes da mesma battle ID.
if($_POST['skillAOE'] == 0) { 
	$playerCurrentStats->strength += $_POST['skillSTR'];
	$playerCurrentStats->intelligence += $_POST['skillINT'];
	$playerCurrentStats->agility += $_POST['skillAGI'];
	$playerCurrentStats->dexterity += $_POST['skillDEX'];
	
	$sql = "UPDATE `player_enemies` SET `player_current_strength`='".$playerCurrentStats->strength."' WHERE `player_id`='".$player->getID()."'";
	query($sql);
	$sql = "UPDATE `player_enemies` SET `player_current_intelligence`='".$playerCurrentStats->intelligence."' WHERE `player_id`='".$player->getID()."'";
	query($sql);
	$sql = "UPDATE `player_enemies` SET `player_current_agility`='".$playerCurrentStats->agility."' WHERE `player_id`='".$player->getID()."'";
	query($sql);
	$sql = "UPDATE `player_enemies` SET `player_current_dexterity`='".$playerCurrentStats->dexterity."' WHERE `player_id`='".$player->getID()."'";
	query($sql);
} else {
	$sql = "SELECT `battle_id` FROM `player_enemies` WHERE `player_id`='".$player->getID()."'";
	$query = query($sql);
	$row = mysql_fetch_assoc($query);
	$sql2 = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$row['battle_id']."'";
	$query2 = query($sql2);
	while($row2 = mysql_fetch_assoc($query2)) {
		$row2['player_current_strength'] += $_POST['skillSTR'];
		$row2['player_current_intelligence'] += $_POST['skillINT'];
		$row2['player_current_agility'] += $_POST['skillAGI'];
		$row2['player_current_dexterity'] += $_POST['skillDEX'];

		$sql = "UPDATE `player_enemies` SET `player_current_strength`='".$row2['player_current_strength']."' WHERE `player_id`='".$row2['player_id']."'";
		query($sql);
		$sql = "UPDATE `player_enemies` SET `player_current_intelligence`='".$row2['player_current_intelligence']."' WHERE `player_id`='".$row2['player_id']."'";
		query($sql);
		$sql = "UPDATE `player_enemies` SET `player_current_agility`='".$row2['player_current_agility']."' WHERE `player_id`='".$row2['player_id']."'";
		query($sql);
		$sql = "UPDATE `player_enemies` SET `player_current_dexterity`='".$row2['player_current_dexterity']."' WHERE `player_id`='".$row2['player_id']."'";
		query($sql);
	}
}

echo json_encode(
	array (
		"playerMP" => $playerCurrentStats->MP,
		"playerStrength" => $playerCurrentStats->strength,
		"playerIntelligence" => $playerCurrentStats->intelligence,
		"playerAgility" => $playerCurrentStats->agility,
		"playerDexterity" => $playerCurrentStats->dexterity
	)
)
?>