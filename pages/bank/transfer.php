<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);

if(!isset($_POST['amount'])) {
	die('Erro.');
}

extract($_POST);

$sql = "SELECT `amount` FROM `bank` WHERE `owner`='".$player->getID()."'";
$query = query($sql);
$bank = mysql_fetch_assoc($query);


$sql2 = "SELECT `amount` FROM `bank` WHERE `account_id`='".$accountID."'";
$query2 = query($sql2);
//Verifica se existe uma conta com esse ID.
$invalidID = 0;
if(mysql_num_rows($query2) == 0) {
	$invalidID = 1;
} else {
	$otherBank = mysql_fetch_assoc($query2);

	//Diminuindo gold do player.
	$bank['amount'] -= $amount;
	$sql = "UPDATE `bank` SET `amount`='".$bank['amount']."' WHERE `owner`='".$player->getID()."'";
	query($sql);

	//Aumentando gold do outro player.
	$otherBank['amount'] += $amount;
	$sql = "UPDATE `bank` SET `amount`='".$otherBank['amount']."' WHERE `account_id`='".$accountID."'";
	query($sql);
}

echo json_encode(
		array (
			"newAmount" => $bank['amount'],
			"invalidID" => $invalidID
		)
	);
?>