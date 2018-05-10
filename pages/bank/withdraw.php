<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);

if(!isset($_POST['amount'])) {
	die('Erro.');
}

extract($_POST);

$sql = "SELECT `amount` FROM `bank` WHERE `account_id`='".$accountID."'";
$query = query($sql);
$bank = mysql_fetch_assoc($query);

//Aumentando gold do player.
$playerGold = $player->getGold();
$playerGold += $amount;
$sql = "UPDATE `users` SET `gold`='".$playerGold."' WHERE `id`='".$player->getID()."'";
query($sql);

//Sacando na conta.
$bank['amount'] -= $amount;
$sql = "UPDATE `bank` SET `amount`='".$bank['amount']."' WHERE `account_id`='".$accountID."'";
query($sql);

echo json_encode(
	array (
		"newAmount" => $bank['amount'],
		"playerGold" => $playerGold
	)
);
?>