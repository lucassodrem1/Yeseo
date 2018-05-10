<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();

$sql = "SELECT `leader_id`, `lobby_id` FROM `lobby` WHERE `lobby_id`='".$_GET['i']."'";
$query = query($sql);
$lobby = mysql_fetch_assoc($query);

//Verificando se player é líder do lobby.
if($player->getID() != $lobby['leader_id']) {
	die('
		<script>
		alert("Você não é o líder desse lobby.");
		hystory.back();
		</script>
	');
}

//Desfazendo lobby
$sql = "DELETE FROM `lobby` WHERE `lobby_id`='".$lobby['lobby_id']."'";
query($sql);

echo'
	<script>
		alert("Você desfez o lobby.");
		location.href="../home.php";
	</script>
';
?>