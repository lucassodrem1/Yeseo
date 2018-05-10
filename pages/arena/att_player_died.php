<?php
require '../../functions.php';
$id = getID($_COOKIE['info']);
$player = new Player($id);
$arena = new Arena($player->getID());

echo json_encode(
	array (
		"playerDied" => $arena->getPlayerDied(),
		"enemyDied" => $arena->getEnemyDied()
	)
);
?>