<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();

$sql = "DELETE FROM `lobby` WHERE `player_id`='".$player->getID()."'";
query($sql);

echo'
	<script>
		alert("Você saiu do lobby.");
		location.href="../home.php";
	</script>
';
?>