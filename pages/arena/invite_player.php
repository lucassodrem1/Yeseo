<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$friend = new Player($_GET['i']);

//Verificando se o player é amigo do invitado.
$sql = "SELECT * FROM `player_friends` WHERE `player_id`='".$player->getID()."' AND `friend_id`='".$friend->getID()."'";
$query = query($sql);
if(mysql_num_rows($query) == 0) {
	die('
		<script>
			alert("Você não é amigo deste player.");
			history.back();
		</script>
	');
}

//Verificando se o player está no mesma andar do invitado.
if($player->getActualFloor() != $friend->getActualFloor()) {
	die('
		<script>
			alert("O jogador invitado não está no mesmo andar.");
			history.back();
		</script>
	');
}

//Verificando se o player invitado já passou por esse boss.
if($friend->getMaxFloor() > $player->getMaxFloor()) {
	die('
		<script>
			alert("O jogador invitado já batalhou contra esse boss.");
			history.back();
		</script>
	');
}

//Verificando se o player já mandou invite para este jogador.
$sql = "SELECT * FROM `messages` WHERE `sender_id`='".$player->getID()."' AND `receiver_id`='".$friend->getID()."' AND `type`='3'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	die("
		<script>
			alert('Você já mandou um convite para este jogador.');
			history.back();
		</script>
	");
}

//Invitando player.
date_default_timezone_set('America/Sao_Paulo');

$sql = "INSERT INTO `messages` (`sender_id`, `receiver_id`, `topic`, `message`, `type`, `time`) VALUES ('".$player->getID()."', '".$friend->getID()."', 'Convite para ARENA.', 'Gostaria de batalhar ao seu lado.', '4', 
		'".date('Y-m-d H:i:s')."')";
query($sql);

echo'
	<script>
		alert("Jogador convidado.");
		history.back();
	</script>
';