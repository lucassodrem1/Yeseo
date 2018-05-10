<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);

if(!isset($_POST['password'])) {
	die('Erro.');
}

extract($_POST);

$accountID = rand();
$sql = "SELECT * FROM `bank` WHERE `account_id`='".$accountID."'";
$query = query($sql);
while(mysql_num_rows($query) != 0) {
	$accountID = rand();
	$sql = "SELECT * FROM `bank` WHERE `account_id`='".$accountID."'";
	$query = query($sql);
}

$sql = "INSERT INTO `bank` (`account_id`, `owner`, `password`) VALUES ('".$accountID."', '".$player->getID()."', '".$password."')";
query($sql);
?>