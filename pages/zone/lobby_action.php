<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$inBattle = 0;
$lobbyExists = 1;

$sql = "SELECT `enemy_id` FROM `player_enemies` WHERE `player_id`='".$player->getID()."'";
$query = query($sql);
$row = mysql_fetch_assoc($query);
if(mysql_num_rows($query) != 0) {
	$inBattle = 1;
}

$sql = "SELECT `lobby_id` FROM `lobby` WHERE `player_id`='".$player->getID()."'";
$query = query($sql);
if(mysql_num_rows($query) == 0) {
	$lobbyExists = 0;
}

echo json_encode (
	array (
		"inBattle" => $inBattle,
		"lobbyExists" => $lobbyExists
	)
)
?>