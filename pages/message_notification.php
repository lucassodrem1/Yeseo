<?php
require '../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();
$haveMessage = 0;
$amount = 0;

$sql = "SELECT * FROM `messages` WHERE `receiver_id`='".$player->getID()."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	$haveMessage = 1;
	$amount = mysql_num_rows($query);
}

echo json_encode(
	array (
	"haveMessage" => $haveMessage,
	"amount" => $amount
	)
);